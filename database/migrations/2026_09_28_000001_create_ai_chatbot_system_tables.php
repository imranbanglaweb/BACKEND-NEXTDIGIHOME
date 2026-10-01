<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. AI Chatbot Settings Table
        if (!Schema::hasTable('ai_chatbot_settings')) {
            Schema::create('ai_chatbot_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('bot_enabled')->default(true);
                $table->string('bot_name')->default('NextDigi AI Concierge');
                $table->string('bot_tagline')->default('Enterprise Solution & AI Specialist');
                $table->string('bot_avatar')->nullable();
                $table->string('primary_provider')->default('gemini'); // gemini, openai, local_rag
                $table->string('fallback_provider')->default('local_rag'); // local_rag, openai, none
                $table->text('gemini_api_key')->nullable();
                $table->string('gemini_model')->default('gemini-1.5-flash');
                $table->text('openai_api_key')->nullable();
                $table->string('openai_model')->default('gpt-4o-mini');
                $table->decimal('temperature', 3, 2)->default(0.70);
                $table->integer('max_tokens')->default(800);
                $table->longText('system_prompt')->nullable();
                $table->text('welcome_msg_en')->nullable();
                $table->text('welcome_msg_bn')->nullable();
                $table->text('welcome_msg_banglish')->nullable();
                $table->json('suggested_chips')->nullable();
                $table->string('whatsapp_number')->default('+8801918329829');
                $table->string('support_email')->default('info@nextdigihome.com');
                $table->string('support_phone')->default('+8801918329829');
                $table->boolean('auto_capture_leads')->default(true);
                $table->boolean('sound_enabled_by_default')->default(false);
                $table->boolean('lead_notification_email')->default(true);
                $table->string('notification_recipient_email')->nullable();
                $table->timestamps();
            });
        }

        // 2. Dynamic RAG Knowledge Base Table
        if (!Schema::hasTable('ai_knowledge_items')) {
            Schema::create('ai_knowledge_items', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('category')->default('general'); // solutions, software_catalog, pricing, faq, company, custom
                $table->text('keywords')->nullable(); // Comma-separated search keywords in EN, BN, Banglish
                $table->longText('content_en')->nullable();
                $table->longText('content_bn')->nullable();
                $table->longText('content_banglish')->nullable();
                $table->json('suggested_questions')->nullable();
                $table->json('actions')->nullable(); // Array of action buttons [{label, url, type, isExternal}]
                $table->json('matched_items')->nullable(); // Array of catalog cards [{id, name, category, tagline, badge, price, url, color}]
                $table->integer('priority')->default(0); // Higher numbers matched first
                $table->unsignedBigInteger('hit_count')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index('category');
                $table->index('is_active');
                $table->index('priority');
            });
        }

        // 3. AI Chat Conversations Session Table
        if (!Schema::hasTable('ai_conversations')) {
            Schema::create('ai_conversations', function (Blueprint $table) {
                $table->id();
                $table->string('session_id')->unique();
                $table->string('user_ip', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('device_type', 30)->nullable(); // desktop, mobile, tablet
                $table->string('detected_language', 15)->default('en'); // en, bn, banglish
                $table->integer('message_count')->default(0);
                $table->string('lead_name')->nullable();
                $table->string('lead_phone')->nullable();
                $table->string('lead_email')->nullable();
                $table->string('lead_service_interest')->nullable();
                $table->string('lead_status')->default('none'); // none, captured, converted, contacted
                $table->boolean('lead_synced_to_inquiries')->default(false);
                $table->unsignedBigInteger('inquiry_id')->nullable();
                $table->smallInteger('satisfaction_score')->nullable(); // 1 = helpful, -1 = unhelpful
                $table->text('first_message')->nullable();
                $table->text('last_message')->nullable();
                $table->timestamps();

                $table->index('lead_status');
                $table->index('detected_language');
                $table->index('created_at');
            });
        }

        // 4. AI Chat Conversation Messages Table
        if (!Schema::hasTable('ai_conversation_messages')) {
            Schema::create('ai_conversation_messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('conversation_id');
                $table->enum('sender', ['user', 'bot', 'system'])->default('user');
                $table->longText('message');
                $table->string('language', 15)->nullable();
                $table->string('provider_used', 50)->nullable(); // gemini, openai, local_rag, fallback
                $table->integer('response_time_ms')->nullable();
                $table->integer('tokens_used')->nullable();
                $table->json('retrieved_knowledge_ids')->nullable();
                $table->enum('feedback', ['like', 'dislike'])->nullable();
                $table->json('metadata')->nullable(); // suggestions, actions, matched_items
                $table->timestamps();

                $table->foreign('conversation_id')->references('id')->on('ai_conversations')->onDelete('cascade');
                $table->index('sender');
                $table->index('created_at');
            });
        }

        // 5. Admin Sidebar Menu Integration
        $this->syncMenus();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_conversation_messages');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('ai_knowledge_items');
        Schema::dropIfExists('ai_chatbot_settings');

        // Remove menus
        if (Schema::hasTable('menus')) {
            $parent = DB::table('menus')->where('menu_slug', 'ai-chatbot')->first();
            if ($parent) {
                DB::table('menus')->where('menu_parent', $parent->id)->delete();
                DB::table('menus')->where('id', $parent->id)->delete();
            }
        }
    }

    private function syncMenus(): void
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $now = Carbon::now();

        // 1. Parent Menu: AI Chatbot Suite
        $parent = DB::table('menus')->where('menu_slug', 'ai-chatbot')->first();
        if (!$parent) {
            $parentId = DB::table('menus')->insertGetId([
                'menu_name' => 'AI Chatbot Suite',
                'menu_slug' => 'ai-chatbot',
                'menu_icon' => 'fa-robot',
                'menu_url' => 'admin.ai-chatbot.dashboard',
                'menu_permission' => null,
                'menu_order' => 8,
                'menu_parent' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $parentId = $parent->id;
            DB::table('menus')->where('id', $parentId)->update([
                'menu_name' => 'AI Chatbot Suite',
                'menu_icon' => 'fa-robot',
                'menu_url' => 'admin.ai-chatbot.dashboard',
                'updated_at' => $now
            ]);
        }

        // 2. Child menus definition
        $children = [
            [
                'menu_name' => 'Chatbot Analytics',
                'menu_slug' => 'ai-chatbot-dashboard',
                'menu_icon' => 'fa-chart-pie',
                'menu_url' => 'admin.ai-chatbot.dashboard',
                'menu_order' => 1,
            ],
            [
                'menu_name' => 'Chat History & Logs',
                'menu_slug' => 'ai-chatbot-conversations',
                'menu_icon' => 'fa-comments',
                'menu_url' => 'admin.ai-chatbot.conversations',
                'menu_order' => 2,
            ],
            [
                'menu_name' => 'Knowledge Base & RAG',
                'menu_slug' => 'ai-chatbot-knowledge-base',
                'menu_icon' => 'fa-brain',
                'menu_url' => 'admin.ai-chatbot.knowledge-base',
                'menu_order' => 3,
            ],
            [
                'menu_name' => 'Captured AI Leads',
                'menu_slug' => 'ai-chatbot-leads',
                'menu_icon' => 'fa-user-check',
                'menu_url' => 'admin.ai-chatbot.leads',
                'menu_order' => 4,
            ],
            [
                'menu_name' => 'Bot Settings & Prompts',
                'menu_slug' => 'ai-chatbot-settings',
                'menu_icon' => 'fa-sliders-h',
                'menu_url' => 'admin.ai-chatbot.settings',
                'menu_order' => 5,
            ],
            [
                'menu_name' => 'RAG Playground',
                'menu_slug' => 'ai-chatbot-playground',
                'menu_icon' => 'fa-terminal',
                'menu_url' => 'admin.ai-chatbot.playground',
                'menu_order' => 6,
            ],
        ];

        foreach ($children as $child) {
            $exists = DB::table('menus')
                ->where('menu_slug', $child['menu_slug'])
                ->first();

            if ($exists) {
                DB::table('menus')
                    ->where('id', $exists->id)
                    ->update([
                        'menu_name' => $child['menu_name'],
                        'menu_icon' => $child['menu_icon'],
                        'menu_url' => $child['menu_url'],
                        'menu_parent' => $parentId,
                        'menu_order' => $child['menu_order'],
                        'updated_at' => $now,
                    ]);
            } else {
                DB::table('menus')->insert([
                    'menu_name' => $child['menu_name'],
                    'menu_slug' => $child['menu_slug'],
                    'menu_icon' => $child['menu_icon'],
                    'menu_url' => $child['menu_url'],
                    'menu_permission' => null,
                    'menu_order' => $child['menu_order'],
                    'menu_parent' => $parentId,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
};
