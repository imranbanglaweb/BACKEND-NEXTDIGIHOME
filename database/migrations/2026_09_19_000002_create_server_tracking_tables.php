<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create server_tracking_logs table
        if (!Schema::hasTable('server_tracking_logs')) {
            Schema::create('server_tracking_logs', function (Blueprint $table) {
                $table->id();
                $table->string('provider', 50); // ga4, meta_capi, tiktok, webhook
                $table->string('event_name', 100); // Lead, Purchase, etc.
                $table->string('event_id', 150)->nullable()->index();
                $table->string('status', 30)->default('pending'); // success, failed, skipped
                $table->integer('http_code')->nullable();
                $table->json('request_payload')->nullable();
                $table->json('response_payload')->nullable();
                $table->text('error_message')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('lead_id', 50)->nullable()->index();
                $table->string('order_id', 50)->nullable()->index();
                $table->timestamps();

                $table->index(['provider', 'status']);
                $table->index('created_at');
            });
        }

        // 2. Add tracking configuration columns to settings table
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                // GA4 Measurement Protocol
                if (!Schema::hasColumn('settings', 'ga4_measurement_id')) {
                    $table->string('ga4_measurement_id', 100)->nullable()->after('google_analytics_id');
                }
                if (!Schema::hasColumn('settings', 'ga4_api_secret')) {
                    $table->string('ga4_api_secret', 255)->nullable()->after('ga4_measurement_id');
                }
                if (!Schema::hasColumn('settings', 'ga4_server_enabled')) {
                    $table->boolean('ga4_server_enabled')->default(true)->after('ga4_api_secret');
                }

                // Meta Conversions API (CAPI)
                if (!Schema::hasColumn('settings', 'meta_pixel_id')) {
                    $table->string('meta_pixel_id', 100)->nullable()->after('ga4_server_enabled');
                }
                if (!Schema::hasColumn('settings', 'meta_capi_access_token')) {
                    $table->text('meta_capi_access_token')->nullable()->after('meta_pixel_id');
                }
                if (!Schema::hasColumn('settings', 'meta_capi_test_event_code')) {
                    $table->string('meta_capi_test_event_code', 100)->nullable()->after('meta_capi_access_token');
                }
                if (!Schema::hasColumn('settings', 'meta_capi_enabled')) {
                    $table->boolean('meta_capi_enabled')->default(true)->after('meta_capi_test_event_code');
                }

                // TikTok Events API
                if (!Schema::hasColumn('settings', 'tiktok_pixel_code')) {
                    $table->string('tiktok_pixel_code', 100)->nullable()->after('meta_capi_enabled');
                }
                if (!Schema::hasColumn('settings', 'tiktok_access_token')) {
                    $table->text('tiktok_access_token')->nullable()->after('tiktok_pixel_code');
                }
                if (!Schema::hasColumn('settings', 'tiktok_test_event_code')) {
                    $table->string('tiktok_test_event_code', 100)->nullable()->after('tiktok_access_token');
                }
                if (!Schema::hasColumn('settings', 'tiktok_server_enabled')) {
                    $table->boolean('tiktok_server_enabled')->default(false)->after('tiktok_test_event_code');
                }

                // Custom Webhook / Server GTM
                if (!Schema::hasColumn('settings', 'server_tracking_webhook_url')) {
                    $table->string('server_tracking_webhook_url', 255)->nullable()->after('tiktok_server_enabled');
                }
                if (!Schema::hasColumn('settings', 'server_tracking_webhook_enabled')) {
                    $table->boolean('server_tracking_webhook_enabled')->default(false)->after('server_tracking_webhook_url');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_tracking_logs');

        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                $columns = [
                    'ga4_measurement_id',
                    'ga4_api_secret',
                    'ga4_server_enabled',
                    'meta_pixel_id',
                    'meta_capi_access_token',
                    'meta_capi_test_event_code',
                    'meta_capi_enabled',
                    'tiktok_pixel_code',
                    'tiktok_access_token',
                    'tiktok_test_event_code',
                    'tiktok_server_enabled',
                    'server_tracking_webhook_url',
                    'server_tracking_webhook_enabled',
                ];

                foreach ($columns as $column) {
                    if (Schema::hasColumn('settings', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
