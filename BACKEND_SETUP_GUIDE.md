# Backend API Setup Guide - Dynamic Content

## Overview

This guide explains how to set up the Laravel backend to provide dynamic content to the Next.js frontend.

## Database Migrations

The following migrations are required:

### 1. Hero Sliders Table

```bash
php artisan make:migration create_hero_sliders_table
```

```php
Schema::create('hero_sliders', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('subtitle')->nullable();
    $table->text('description')->nullable();
    $table->string('cta_text')->nullable();
    $table->string('cta_link')->nullable();
    $table->string('image')->nullable();
    $table->string('background_color')->nullable()->default('#0f0f12');
    $table->string('text_color')->nullable()->default('#fafafa');
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 2. Page Content Table

```bash
php artisan make:migration create_page_content_table
```

```php
Schema::create('page_content', function (Blueprint $table) {
    $table->id();
    $table->string('page'); // home, about, contact, privacy, terms
    $table->string('section'); // hero, mission, vision, features, etc.
    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->longText('content')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    
    $table->index(['page', 'section']);
});
```

### 3. Stats Table

```bash
php artisan make:migration create_stats_table
```

```php
Schema::create('stats', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique(); // products_sold, happy_customers, etc.
    $table->string('value'); // 10K+, 50K+, etc.
    $table->string('label'); // Products Sold, Happy Customers, etc.
    $table->string('icon')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 4. Team Members Table

```bash
php artisan make:migration create_team_members_table
```

```php
Schema::create('team_members', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('position');
    $table->text('bio')->nullable();
    $table->string('image')->nullable();
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 5. Contact Info Table

```bash
php artisan make:migration create_contact_info_table
```

```php
Schema::create('contact_info', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // email, phone, address, hours
    $table->string('label');
    $table->text('value');
    $table->text('description')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 6. Testimonials Table

```bash
php artisan make:migration create_testimonials_table
```

```php
Schema::create('testimonials', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('role')->nullable();
    $table->text('content');
    $table->integer('rating')->nullable(); // 1-5 stars
    $table->string('image')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

## Run Migrations

```bash
php artisan migrate
```

## Create Models

Create Eloquent models for each table:

```bash
php artisan make:model HeroSlider
php artisan make:model PageContent
php artisan make:model Stat
php artisan make:model TeamMember
php artisan make:model ContactInfo
php artisan make:model Testimonial
```

## Add Query Scopes

Add query scopes to all models for filtering active records:

```php
// In each Model class
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeOrdered($query)
{
    return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
}

// For PageContent model
public function scopePage($query, $page)
{
    return $query->where('page', $page);
}

public function scopeSection($query, $section)
{
    return $query->where('section', $section);
}
```

## Create Seeder

Create a seeder to populate initial data:

```bash
php artisan make:seeder ContentSeeder
```

```php
<?php

namespace Database\Seeders;

use App\Models\HeroSlider;
use App\Models\PageContent;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run()
    {
        // Hero Sliders
        HeroSlider::create([
            'title' => 'Launch Your Business',
            'subtitle' => 'With Premium Tools',
            'description' => 'Curated collection of premium digital products designed to accelerate your business growth.',
            'cta_text' => 'Explore Products',
            'cta_link' => '/products',
            'image' => '🎯',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Home Page Content - Features
        PageContent::create([
            'page' => 'home',
            'section' => 'features',
            'title' => 'Instant Access',
            'description' => 'Download immediately after purchase',
            'content' => 'Download immediately after purchase - no waiting, no shipping delays. Get started right away.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Statistics
        Stat::create([
            'key' => 'products_sold',
            'value' => '10K+',
            'label' => 'Products Sold',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Team Members
        TeamMember::create([
            'name' => 'Imran Rahman',
            'position' => 'CEO',
            'bio' => 'Visionary leader driving digital innovation and business growth',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Contact Info
        ContactInfo::create([
            'type' => 'email',
            'label' => 'Email Us',
            'value' => 'support@nextdigihome.com',
            'description' => 'We respond within 24 hours',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}
```

## Run Seeder

```bash
php artisan db:seed --class=ContentSeeder
# or seed everything
php artisan db:seed
```

## API Controllers

The following controllers handle API responses:

- `ContentManagementController` - Content endpoints
- `HeroSliderController` - Hero slider management
- `PageContentController` - Page content CRUD
- `StatsController` - Statistics management
- `TeamMemberController` - Team member management
- `ContactInfoController` - Contact information management
- `TestimonialsController` - Testimonials management

## API Routes

Routes are defined in `routes/api.php`:

```php
Route::middleware(['cors', 'api'])->group(function () {
    // Content Management (for frontend)
    Route::get('content/home', [ContentManagementController::class, 'getHomeContent']);
    Route::get('content/about', [ContentManagementController::class, 'getAboutContent']);
    Route::get('content/contact', [ContentManagementController::class, 'getContactContent']);
    Route::get('content/privacy', [ContentManagementController::class, 'getPrivacyContent']);
    Route::get('content/terms', [ContentManagementController::class, 'getTermsContent']);

    // Resource endpoints
    Route::apiResource('hero-sliders', HeroSliderController::class);
    Route::apiResource('page-content', PageContentController::class);
    Route::apiResource('stats', StatsController::class);
    Route::apiResource('team-members', TeamController::class);
    Route::apiResource('contact-info', ContactInfoController::class);
});
```

## CORS Configuration

Ensure CORS is properly configured in `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:3000', 'http://localhost:8000'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

## Testing API Endpoints

```bash
# Test home content
curl http://localhost:8000/api/content/home

# Test about content
curl http://localhost:8000/api/content/about

# Test contact content
curl http://localhost:8000/api/content/contact

# Test privacy content
curl http://localhost:8000/api/content/privacy

# Test terms content
curl http://localhost:8000/api/content/terms
```

## Expected Response Format

All endpoints return this format:

```json
{
  "success": true,
  "data": {
    "hero_sliders": [...],
    "stats": [...],
    "features": [...]
  }
}
```

## Updating Content

### Via Database

```bash
php artisan tinker

# Update hero slider
$slider = App\Models\HeroSlider::first();
$slider->update(['title' => 'New Title']);

# Create new stat
App\Models\Stat::create([
    'key' => 'new_key',
    'value' => 'New Value',
    'label' => 'New Label',
    'is_active' => true
]);
```

### Via Admin Dashboard

Admins can manage content through the built-in admin interface at `/admin`.

## Troubleshooting

### Issue: Migration fails due to existing table

```bash
php artisan migrate:reset
php artisan migrate
```

### Issue: Seeder doesn't populate data

Check if models are properly configured:
```bash
php artisan tinker
App\Models\HeroSlider::count()
```

### Issue: API returns empty data

Ensure data is active:
```bash
php artisan tinker
App\Models\HeroSlider::where('is_active', true)->count()
```

## Production Deployment

1. Run migrations on production:
   ```bash
   php artisan migrate --force
   ```

2. Seed initial data:
   ```bash
   php artisan db:seed --class=ContentSeeder --force
   ```

3. Cache configuration:
   ```bash
   php artisan config:cache
   ```

4. Clear cache:
   ```bash
   php artisan cache:clear
   ```

## Next Steps

1. ✅ Create migrations and models
2. ✅ Run migrations
3. ✅ Create and run seeders
4. ✅ Test API endpoints
5. ✅ Configure frontend `.env.local`
6. ✅ Start frontend dev server
7. ✅ Verify data is loading on pages
