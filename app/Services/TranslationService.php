<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use App\Models\Language;

class TranslationService
{
    protected ?string $fallbackLocale;

    public function __construct()
    {
        $this->fallbackLocale = $this->resolveFallbackLocale();
    }

    /**
     * Get current locale dynamically
     */
    protected function getCurrentLocale(): string
    {
        return session('locale', App::getLocale());
    }

    /**
     * Get translation from database
     */
    public function get(string $key, string $group = 'frontend', array $parameters = [], ?string $locale = null): string
    {
        $locale = $locale ?: $this->getCurrentLocale();

        // Load all translations for locale + group
        $translations = $this->getCachedGroupTranslations($group, $locale);

        // Try requested locale
        $value = $translations[$key] ?? null;

        // Fallback locale
        if ($value === null && $this->fallbackLocale && $locale !== $this->fallbackLocale) {
            $fallbackTranslations = $this->getCachedGroupTranslations($group, $this->fallbackLocale);
            $value = $fallbackTranslations[$key] ?? null;
        }

        // Original text fallback
        if ($value === null) {
            $value = DB::table('translations')
                ->where('group', $group)
                ->where('key', $key)
                ->value('text');
        }

        // Final fallback
        $value = $value ?: $key;

        // Replace parameters
        return $this->replaceParameters($value, $parameters);
    }

    /**
     * Cache translations by group + locale
     */
    public function getCachedGroupTranslations(string $group, string $locale): array
    {
        return Cache::remember(
            "translations.{$group}.{$locale}",
            now()->addHours(24),
            function () use ($group, $locale) {
                return DB::table('translation_values')
                    ->join('translations', 'translation_values.translation_id', '=', 'translations.id')
                    ->where('translations.group', $group)
                    ->where('translation_values.language_code', $locale)
                    ->pluck('translation_values.value', 'translations.key')
                    ->toArray();
            }
        );
    }

    /**
     * Replace :parameters
     */
    protected function replaceParameters(string $value, array $parameters): string
    {
        foreach ($parameters as $key => $replace) {
            $value = str_replace(':' . $key, $replace, $value);
        }

        return $value;
    }

    /**
     * Resolve default language from DB
     */
    protected function resolveFallbackLocale(): ?string
    {
        return Cache::rememberForever('default_locale', function () {
            return Language::where('is_default', 1)->value('code');
        });
    }

    /**
     * Set / Update translation
     */
    public function set(string $key, string $value, string $group = 'frontend', ?string $locale = null): void
    {
        $locale = $locale ?: $this->getCurrentLocale();

        DB::transaction(function () use ($key, $value, $group, $locale) {
            $translation = DB::table('translations')
                ->where('group', $group)
                ->where('key', $key)
                ->first();

            if (!$translation) {
                try {
                    $translationId = DB::table('translations')->insertGetId([
                        'group' => $group,
                        'key' => $key,
                        'text' => $this->fallbackLocale === $locale ? $value : '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->errorInfo[1] == 1062) {
                        $translation = DB::table('translations')
                            ->where('group', $group)
                            ->where('key', $key)
                            ->first();
                        $translationId = $translation->id;
                    } else {
                        throw $e;
                    }
                }
            } else {
                $translationId = $translation->id;
            }

            DB::table('translation_values')->updateOrInsert(
                [
                    'translation_id' => $translationId,
                    'language_code' => $locale,
                ],
                [
                    'value' => $value,
                    'updated_at' => now(),
                ]
            );
        });

        $this->clearGroupCache($group);
    }

    /**
     * Clear cache for group
     */
    protected function clearGroupCache(string $group): void
    {
        $currentLocale = $this->getCurrentLocale();
        Cache::forget("translations.{$group}.{$currentLocale}");

        if ($this->fallbackLocale) {
            Cache::forget("translations.{$group}.{$this->fallbackLocale}");
        }
    }

    /**
     * Get all translations
     */
    public function getAll(string $group = 'frontend', ?string $locale = null): array
    {
        $locale = $locale ?: $this->getCurrentLocale();
        return $this->getCachedGroupTranslations($group, $locale);
    }

    /**
     * Get available languages
     */
    public function getLanguages()
    {
        return Cache::remember('available_languages', now()->addHours(24), function () {
            return Language::where('is_active', 1)
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Validate language
     */
    public function isValidLanguage(string $locale): bool
    {
        return Language::where('code', $locale)
            ->where('is_active', 1)
            ->exists();
    }

    /**
     * Clear all translation caches
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
