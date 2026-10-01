<?php

namespace App\Services;

use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;

class CustomTranslationLoader extends FileLoader
{
    protected $translationService;

    public function __construct(Filesystem $files, $path)
    {
        parent::__construct($files, $path);
        $this->translationService = app(TranslationService::class);
    }

    public function load($locale, $group, $namespace = null)
    {
        // First, try to load from database
        $dbTranslations = $this->loadFromDatabase($locale, $group);

        // Then load from files
        $fileTranslations = parent::load($locale, $group, $namespace);

        // Merge, with database taking precedence
        return array_merge($fileTranslations, $dbTranslations);
    }

    protected function loadFromDatabase($locale, $group)
    {
        // Use the TranslationService to load
        $translations = $this->translationService->getCachedGroupTranslations($group, $locale);

        return $translations;
    }
}