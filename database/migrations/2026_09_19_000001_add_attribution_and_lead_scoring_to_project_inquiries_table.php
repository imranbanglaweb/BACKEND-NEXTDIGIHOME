<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('project_inquiries')) {
            Schema::table('project_inquiries', function (Blueprint $table) {
                if (!Schema::hasColumn('project_inquiries', 'lead_id')) {
                    $table->string('lead_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('project_inquiries', 'whatsapp')) {
                    $table->string('whatsapp')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('project_inquiries', 'website')) {
                    $table->string('website')->nullable()->after('company');
                }
                if (!Schema::hasColumn('project_inquiries', 'service_details')) {
                    $table->json('service_details')->nullable()->after('service');
                }
                if (!Schema::hasColumn('project_inquiries', 'contact_method')) {
                    $table->string('contact_method')->nullable()->after('timeline');
                }
                if (!Schema::hasColumn('project_inquiries', 'lead_source')) {
                    $table->string('lead_source')->nullable()->after('contact_method');
                }
                if (!Schema::hasColumn('project_inquiries', 'landing_page')) {
                    $table->string('landing_page')->nullable()->after('lead_source');
                }
                if (!Schema::hasColumn('project_inquiries', 'referrer')) {
                    $table->string('referrer')->nullable()->after('landing_page');
                }
                if (!Schema::hasColumn('project_inquiries', 'utm_source')) {
                    $table->string('utm_source')->nullable()->after('referrer');
                    $table->string('utm_medium')->nullable()->after('utm_source');
                    $table->string('utm_campaign')->nullable()->after('utm_medium');
                    $table->string('utm_content')->nullable()->after('utm_campaign');
                    $table->string('utm_term')->nullable()->after('utm_content');
                }
                if (!Schema::hasColumn('project_inquiries', 'first_touch_json')) {
                    $table->json('first_touch_json')->nullable()->after('utm_term');
                }
                if (!Schema::hasColumn('project_inquiries', 'last_touch_json')) {
                    $table->json('last_touch_json')->nullable()->after('first_touch_json');
                }
                if (!Schema::hasColumn('project_inquiries', 'event_id')) {
                    $table->string('event_id')->nullable()->after('last_touch_json');
                }
                if (!Schema::hasColumn('project_inquiries', 'file_name')) {
                    $table->string('file_name')->nullable()->after('message');
                    $table->unsignedBigInteger('file_size')->nullable()->after('file_name');
                    $table->string('file_type')->nullable()->after('file_size');
                }
                if (!Schema::hasColumn('project_inquiries', 'priority')) {
                    $table->string('priority')->default('LOW')->after('status');
                }
                if (!Schema::hasColumn('project_inquiries', 'lead_score')) {
                    $table->integer('lead_score')->default(20)->after('priority');
                }
                if (!Schema::hasColumn('project_inquiries', 'score_reasons')) {
                    $table->json('score_reasons')->nullable()->after('lead_score');
                }
                if (!Schema::hasColumn('project_inquiries', 'notes')) {
                    $table->json('notes')->nullable()->after('score_reasons');
                }
                if (!Schema::hasColumn('project_inquiries', 'follow_up')) {
                    $table->json('follow_up')->nullable()->after('notes');
                }
                if (!Schema::hasColumn('project_inquiries', 'assigned_to')) {
                    $table->string('assigned_to')->nullable()->after('follow_up');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('project_inquiries')) {
            Schema::table('project_inquiries', function (Blueprint $table) {
                $columns = [
                    'lead_id', 'whatsapp', 'website', 'service_details',
                    'contact_method', 'lead_source', 'landing_page', 'referrer',
                    'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term',
                    'first_touch_json', 'last_touch_json', 'event_id',
                    'file_name', 'file_size', 'file_type',
                    'priority', 'lead_score', 'score_reasons', 'notes', 'follow_up', 'assigned_to'
                ];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('project_inquiries', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
