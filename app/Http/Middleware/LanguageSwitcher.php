<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LanguageSwitcher
{
    public function handle($request, Closure $next)
    {
        // 1. Check URL parameter first
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            $this->setLanguage($locale);
        }
        // 2. Check route parameter
        elseif ($request->route('locale')) {
            $locale = $request->route('locale');
            $this->setLanguage($locale);
        }
        // 3. Check session
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
        }
        // 4. Check user preference
        elseif (Auth::check() && Auth::user()->preferred_language) {
            $locale = Auth::user()->preferred_language;
            $this->setLanguage($locale);
        }
        // 5. Detect from browser
        else {
            $locale = $this->detectBrowserLanguage();
            $this->setLanguage($locale);
        }
        
        // Share with all views
        view()->share('currentLocale', App::getLocale());
        view()->share('availableLanguages', available_languages());
        
        return $next($request);
    }
    
    private function setLanguage($locale)
    {
        // Validate language exists and active
        $language = \App\Models\Language::where('code', $locale)
            ->where('is_active', true)
            ->first();
            
        if ($language) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            
            // Update user preference if logged in
            if (Auth::check()) {
                Auth::user()->update(['preferred_language' => $locale]);
            }
            
            // Set RTL/LTR direction
            Session::put('direction', $language->direction);
        }
    }
    
    private function detectBrowserLanguage()
    {
        $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
        
        $available = \App\Models\Language::where('is_active', true)
            ->pluck('code')
            ->toArray();
            
        return in_array($browserLang, $available) ? $browserLang : 'en';
    }
}
