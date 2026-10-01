<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $baseUrl = rtrim(config('app.url'), '/');

        DB::table('products')
            ->orderBy('id')
            ->chunkById(100, function ($products) use ($baseUrl) {
                foreach ($products as $product) {
                    $plainDescription = trim(strip_tags((string) ($product->description ?: $product->detailed_description)));
                    $seoDescription = $plainDescription
                        ? Str::limit(preg_replace('/\s+/', ' ', $plainDescription), 160, '')
                        : 'Discover ' . $product->name . ' from Next Digi Home.';

                    $keywords = $this->buildKeywords($product);
                    $canonicalUrl = $baseUrl . '/products/' . $product->slug;
                    $ogImage = $product->thumbnail
                        ? $baseUrl . '/public/storage/' . ltrim($product->thumbnail, '/')
                        : null;

                    DB::table('products')
                        ->where('id', $product->id)
                        ->update([
                            'seo_title' => $this->valueOrFallback($product->seo_title ?? null, Str::limit($product->name, 60, '')),
                            'seo_description' => $this->valueOrFallback($product->seo_description ?? null, $seoDescription),
                            'seo_keywords' => $this->valueOrFallback($product->seo_keywords ?? null, $keywords),
                            'canonical_url' => $this->valueOrFallback($product->canonical_url ?? null, $canonicalUrl),
                            'og_title' => $this->valueOrFallback($product->og_title ?? null, Str::limit($product->name, 90, '')),
                            'og_description' => $this->valueOrFallback($product->og_description ?? null, Str::limit($seoDescription, 190, '')),
                            'og_image' => $this->valueOrFallback($product->og_image ?? null, $ogImage),
                            'robots_index' => $product->robots_index ?? true,
                            'robots_follow' => $product->robots_follow ?? true,
                            'updated_at' => now(),
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Keep generated SEO data. Dropping columns is handled by the schema migration.
    }

    private function valueOrFallback($value, $fallback)
    {
        return filled($value) ? $value : $fallback;
    }

    private function buildKeywords($product): string
    {
        $keywords = [
            $product->name,
            $product->category,
            'digital product',
            'Next Digi Home',
        ];

        if (!empty($product->tags)) {
            $tags = is_string($product->tags)
                ? json_decode($product->tags, true)
                : $product->tags;

            if (!is_array($tags)) {
                $tags = array_map('trim', explode(',', (string) $product->tags));
            }

            $keywords = array_merge($keywords, $tags);
        }

        return collect($keywords)
            ->filter()
            ->map(fn ($keyword) => trim((string) $keyword))
            ->filter()
            ->unique()
            ->take(12)
            ->implode(', ');
    }
};
