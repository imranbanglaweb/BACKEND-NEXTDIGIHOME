<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Room;
use App\Models\IssueRegister;
use App\Models\Category;
Use \Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Support\Facades\Config;
use App\Models\Requisition;
use App\Observers\RequisitionObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Translation\Translator;
use App\Services\DatabaseTranslationLoader;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Override the translation loader to use database
        $this->app->singleton('translation.loader', function ($app) {
            return new DatabaseTranslationLoader($app->make('App\Services\TranslationService'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Replace the translator's loader with our database loader
        $translator = $this->app['translator'];
        $reflection = new \ReflectionClass($translator);
        $loaderProperty = $reflection->getProperty('loader');
        $loaderProperty->setAccessible(true);
        $loaderProperty->setValue($translator, new DatabaseTranslationLoader($this->app->make('App\Services\TranslationService')));
        
        // Clear any previously loaded translations to force reload with new loader
        $loadedProperty = $reflection->getProperty('loaded');
        $loadedProperty->setAccessible(true);
        $loadedProperty->setValue($translator, []);

        if ($this->app->environment('local')) {
        // Suppress specific warnings from thecodingmachine/safe
        set_error_handler(function ($severity, $message, $file, $line) {
            // Only ignore warnings from thecodingmachine/safe
            if (strpos($file, 'vendor/thecodingmachine/safe') !== false) {
                return true; // Ignore warning
            }

            // Otherwise, use default handler
            return false;
        }, E_WARNING);

        // Requisition::observe(RequisitionObserver::class);
}


        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        // Add this if your app is in a subdirectory
        \URL::forceRootUrl(config('app.url'));

        view()->composer(['admin.dashboard.admin.dashboard', 'admin.dashboard.common.sidebar'], function ($view) {
$sidebar_menus = Menu::orderBy('id','ASC')->where('menu_parent',0)->get();
     
        $view->with('sidebar_menus', $sidebar_menus);
        });


        view()->composer(['admin.dashboard.common.header','admin.dashboard.common.sidebar'], function ($view) {

            $settings = DB::table('settings')->where('id',1)->first();
     
            $view->with('settings',$settings);

        });        

        view()->composer(['frontend.home'], function ($view) {

            $sliders = DB::table('sliders')->get();
     
            $view->with('sliders',$sliders);

        });       

        view()->composer(['frontend.home'], function ($view) {

            $counter  = DB::table('offers')->count();
            $offers = DB::table('offers')->get();
     
            $view->with('offers',$offers,'counter',$counter);

        });       
    
        // Configure mail theme
        Config::set('mail.markdown.theme', 'default');
        Config::set('mail.markdown.paths', [resource_path('views/vendor/mail')]);


              // Custom blade directive for database translation
            Blade::directive('trans', function ($expression) {
                return "<?php echo trans_db({$expression}); ?>";
            });
            
            Blade::directive('transchoice', function ($expression) {
                return "<?php echo trans_db({$expression}); ?>";
            });
            
            // RTL/LTR directive
            Blade::if('rtl', function () {
                return session('direction', 'ltr') === 'rtl';
            });
    
            Blade::if('ltr', function () {
                return session('direction', 'ltr') === 'ltr';
            });
    }
}
