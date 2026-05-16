<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Language;
use App\Services\TranslationService;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Pagination\LengthAwarePaginator;
class TranslationController extends Controller
{
    protected $translationService;
    
    
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
         // Ensure helpers are loaded (only if composer autoload didn't work)
        if (!function_exists('available_languages')) {
            require_once app_path('Helpers/TranslationHelpers.php');
        }
    }
    
    // public function index(Request $request)
    // {
       

    //    $translations = Translation::when($request->search, function ($q) use ($request) {
    //     $q->where('key', 'like', '%'.$request->search.'%')
    //       ->orWhere('value', 'like', '%'.$request->search.'%');
    // })->get();

    // if ($request->ajax()) {
    //     return response()->json([
    //         'html' => view('admin.translations.partials.rows', compact('translations'))->render()
    //     ]);
    // }

    // return view('admin.dashboard.translations.index', [
    //     'translations' => new LengthAwarePaginator([], 0, 50),
    //     'search' => null,
    //     'languages' => available_languages()
    // ]);


    // }


    // AJAX method to get translations with pagination and search
    public function index(Request $request)
{
    $translations = Translation::when($request->search, function ($q) use ($request) {
        $q->where('key', 'like', '%'.$request->search.'%')
          ->orWhere('value', 'like', '%'.$request->search.'%');
    })->orderBy('id','desc')->get();

    if ($request->ajax()) {
        return response()->json([
            'html' => view(
                'admin.dashboard.translations.partials.rows',
                compact('translations')
            )->render()
        ]);
    }

    return view('admin.dashboard.translations.index', compact('translations'));
}
public function ajaxTranslations(Request $request)
{
    $search = $request->input('search', '');
    $perPage = 10;
    
    // Base query
    $query = \DB::table('translations');

    if ($search) {
        $query->where('key', 'like', "%{$search}%")
              ->orWhere('group', 'like', "%{$search}%");
    }

    // Get total count for paginator
    $total = $query->count();

    // Get current page
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $perPage;

    // Get rows
    $translations = $query->orderBy('group')->orderBy('key')
                          ->offset($offset)->limit($perPage)
                          ->get();

    // Transform rows
    $rows = $translations->map(function($t) {
        $values = [];
        foreach (available_languages() as $lang) {
            $value = \DB::table('translation_values')
                        ->where('translation_id', $t->id)
                        ->where('language_code', $lang->code)
                        ->value('value');
            $values[$lang->code] = $value ?? '';
        }
        return [
            'id' => $t->id,
            'key' => $t->key,
            'group' => $t->group,
            'values' => $values,
        ];
    });

    // Prepare LengthAwarePaginator-like JSON
    return response()->json([
        'translations' => $rows,
        'pagination' => [
            'current_page' => (int)$page,
            'last_page' => (int)ceil($total / $perPage),
            'per_page' => $perPage,
            'total' => $total,
        ]
    ]);
}


public function create(Request $request){
    $request->validate([
        'key'=>'required|string|max:255',
        'translations'=>'required|array',
    ]);

    $translation = Translation::create([
        'key'=>$request->key,
        'group'=>$request->group ?? null
    ]);

    foreach($request->translations as $lang=>$val){
        $translation->values()->create([
            'lang_code'=>$lang,
            'value'=>$val
        ]);
    }

    return response()->json([
        'success'=>true,
        'translation'=>[
            'id'=>$translation->id,
            'key'=>$translation->key,
            'group'=>$translation->group,
            'values'=>$translation->values->pluck('value','lang_code')->toArray()
        ]
    ]);
}

   
    
   public function update(Request $request)
        {
            try {
                $validated = $request->validate([
                    'translation_id' => 'required|exists:translations,id',
                    'translations' => 'required|array'
                ]);

                $translation = Translation::find($validated['translation_id']);

                foreach ($validated['translations'] as $lang => $value) {
                    $this->translationService->set(
                        $translation->key,
                        $value,
                        $translation->group,
                        $lang
                    );
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Translation saved successfully'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Return validation errors as JSON
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                // Any other exception
                \Log::error('Translation update error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Server error'
                ], 500);
            }
        }

    
    public function autoTranslate(Request $request)
    {
        $validated = $request->validate([
            'translation_id' => 'sometimes|exists:translations,id',
            'translation_ids' => 'sometimes|array',
            'translation_ids.*' => 'exists:translations,id',
            'source_text' => 'sometimes|string'
        ]);

        $languages = Language::where('is_active', true)
            ->where('code', '!=', 'en')
            ->get();

        if (isset($validated['translation_ids'])) {
            // Bulk translation
            foreach ($validated['translation_ids'] as $id) {
                $translation = Translation::find($id);
                if ($translation) {

                    $sourceText = $this->translationService->get($translation->key, $translation->group, [], 'en');

                    if($sourceText){
                        foreach ($languages as $language) {
                            try {
                                $translator = new GoogleTranslate();
                                $translator->setSource('en');
                                $translator->setTarget($language->code);
                                
                                $translatedText = $translator->translate($sourceText);
                                
                                $this->translationService->set(
                                    $translation->key,
                                    $translatedText,
                                    $translation->group,
                                    $language->code
                                );
                            } catch (\Exception $e) {
                                // Log error but continue with other languages/translations
                                \Log::error("Could not auto-translate key {$translation->key} to {$language->code}: " . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } elseif (isset($validated['translation_id'])) {
            // Single translation
            $translation = Translation::find($validated['translation_id']);
            $sourceText = $validated['source_text'];
            $results = [];

            foreach ($languages as $language) {
                try {
                    $translator = new GoogleTranslate();
                    $translator->setSource('en');
                    $translator->setTarget($language->code);
                    
                    $translatedText = $translator->translate($sourceText);
                    
                    $this->translationService->set(
                        $translation->key,
                        $translatedText,
                        $translation->group,
                        $language->code
                    );
                    
                    $results[$language->code] = $translatedText;
                } catch (\Exception $e) {
                    $results[$language->code] = null;
                }
            }
            return response()->json([
                'success' => true,
                'translations' => $results
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No translation ID(s) provided.'
            ], 400);
        }

        return response()->json(['success' => true, 'message' => 'Auto-translation completed.']);
    }

    public function store(Request $request)
    {
        // Validate English field only
        $request->validate([
            'group' => 'required|string|max:255',
            'key'   => 'required|string|max:255',
            'values.en' => 'required|string|max:65535', // English required
        ], [
            'values.en.required' => 'English value is required',
        ]);

        // Check if key already exists in the group
        $exists = Translation::where('group', $request->group)
                             ->where('key', $request->key)
                             ->first();

        if($exists){
            return response()->json([
                'success' => false,
                'message' => 'This key already exists in the selected group'
            ]);
        }

        // Prepare values
        $values = $request->values;

        // Create translation
        $translation = Translation::create([
            'group' => $request->group,
            'key'   => $request->key,
            // 'text' => json_encode($values), // assuming values stored as JSON
                'text'  => $request->values['en'] ?? '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Translation added successfully',
            'translation_id' => $translation->id,
        ]);
    }
}