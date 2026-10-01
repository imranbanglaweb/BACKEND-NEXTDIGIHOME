<?php

namespace Database\Seeders;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FlagshipProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $storageDir = storage_path('app/public/products/thumbnails');

        if (!File::isDirectory($storageDir)) {
            File::makeDirectory($storageDir, 0755, true, true);
        }

        $flagships = [
            [
                'name' => 'NextDigi Headless Commerce Storefront',
                'slug' => 'nextdigi-headless-commerce',
                'description' => 'Production-ready Next.js 15 e-commerce engine with bKash, Nagad, Stripe, and automated courier consignment dispatch.',
                'detailed_description' => 'Engineered for high-volume enterprise stores and DTC brands. Built with Next.js 15 App Router, React Server Components, TypeScript, Tailwind CSS, and headless Laravel API backend. Includes native Bangladesh payment gateways (bKash tokenized checkout, Nagad, SSLCommerz, Rocket) alongside Stripe global payments. Features automated courier integration (Pathao, Steadfast, RedX API) for 1-click consignment generation and parcel live tracking.',
                'price' => 9999,
                'compare_price' => 14999,
                'stock' => 50,
                'digital' => true,
                'category' => 'Source Code',
                'product_kind' => 'ecommerce_template',
                'purchase_type' => 'one_time',
                'tags' => ['nextjs', 'ecommerce', 'source-code', 'bkash', 'nagad', 'headless', 'stripe'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1556742049-0a67c5574f73?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Flutter Multipurpose Mobile App Template',
                'slug' => 'flutter-multipurpose-mobile-app',
                'description' => 'Cross-platform iOS & Android mobile application with biometric auth, push alerts, offline sync, and clean Bloc architecture.',
                'detailed_description' => 'Comprehensive production-ready Flutter 3 codebase for iOS and Android. Built with clean architecture, BLoC pattern state management, Hive local cache database, Firebase Push Notifications, and Biometric fingerprint/FaceID authentication. Ready to be rebranded and published directly to Apple App Store and Google Play Store.',
                'price' => 7499,
                'compare_price' => 11999,
                'stock' => 40,
                'digital' => true,
                'category' => 'Mobile Apps',
                'product_kind' => 'website_template',
                'purchase_type' => 'one_time',
                'tags' => ['flutter', 'mobile-app', 'ios', 'android', 'bloc', 'firebase', 'clean-code'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Enterprise SaaS Admin & Billing Dashboard',
                'slug' => 'enterprise-saas-admin-billing',
                'description' => 'Multi-tenant subscription architecture with automated recurring billing, team workspace invites, and role-based ACL.',
                'detailed_description' => 'Enterprise-grade multi-tenant SaaS foundation. Features workspace team management, granular role-based permissions (RBAC), automated recurring subscription billing, invoice PDF generation, activity audit logs, and dark mode interface. Built with React, Next.js, TypeScript, and Tailwind CSS.',
                'price' => 12499,
                'compare_price' => 18999,
                'stock' => 35,
                'digital' => true,
                'category' => 'Source Code',
                'product_kind' => 'website_template',
                'purchase_type' => 'one_time',
                'tags' => ['saas', 'admin-dashboard', 'multi-tenant', 'billing', 'nextjs', 'tailwind'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Autonomous AI Customer Support Agent',
                'slug' => 'autonomous-ai-customer-support-agent',
                'description' => 'Production RAG chatbot with private vector search, WhatsApp Business API integration, and CRM ticket handoff.',
                'detailed_description' => 'Enterprise autonomous customer support AI engine with hybrid RAG retrieval, vector database knowledge indexing, bilingual Bengali & English natural language understanding, WhatsApp Cloud API webhook connector, and automated lead capture with live agent CRM handoff.',
                'price' => 8999,
                'compare_price' => 13500,
                'stock' => 60,
                'digital' => true,
                'category' => 'AI & Automation',
                'product_kind' => 'digital_download',
                'purchase_type' => 'one_time',
                'tags' => ['ai-agent', 'rag', 'chatbot', 'whatsapp-api', 'automation', 'crm'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'NextDigi Workshop & Fleet ERP Suite',
                'slug' => 'nextdigi-workshop-fleet-erp',
                'description' => 'Cloud garage & automotive ERP with digital job-cards, barcode spare-parts inventory, and automated customer SMS status.',
                'detailed_description' => 'Automotive repair shop & fleet maintenance operating system. Includes digital vehicle intake checklists with camera damage photo uploads, spare parts inventory with barcode scanner, mechanic labor allocation, and customer SMS delivery notifications with digital invoices.',
                'price' => 15999,
                'compare_price' => 24999,
                'stock' => 25,
                'digital' => true,
                'category' => 'Business Tools',
                'product_kind' => 'saas',
                'purchase_type' => 'lifetime',
                'tags' => ['erp', 'automotive', 'garage-management', 'fleet', 'inventory', 'sms'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Omnichannel Social Media Scheduler SaaS',
                'slug' => 'omnichannel-social-scheduler',
                'description' => 'Full-stack platform to schedule posts across Facebook, Instagram, LinkedIn, and TikTok with AI caption generator.',
                'detailed_description' => 'Multi-platform social media publishing suite. Schedule posts, reels, and stories with media preview canvas, automated AI caption generator, hashtag finder, and queue analytics across Facebook Pages, Instagram Graph, LinkedIn, and YouTube.',
                'price' => 10999,
                'compare_price' => 16500,
                'stock' => 30,
                'digital' => true,
                'category' => 'Source Code',
                'product_kind' => 'website_template',
                'purchase_type' => 'one_time',
                'tags' => ['social-media', 'scheduler', 'saas', 'meta-api', 'ai-caption', 'automation'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Multi-Vendor Food & Grocery Delivery Platform',
                'slug' => 'multi-vendor-food-grocery-delivery',
                'description' => 'Complete rider tracking, restaurant dispatch panel, customer web app & real-time delivery estimation engine.',
                'detailed_description' => 'Turnkey multi-vendor delivery marketplace similar to Foodpanda/UberEats. Features customer ordering PWA, restaurant vendor dashboard for orders and menus, rider live GPS dispatch app with route optimization, and admin commission manager.',
                'price' => 18999,
                'compare_price' => 28000,
                'stock' => 20,
                'digital' => true,
                'category' => 'Source Code',
                'product_kind' => 'ecommerce_template',
                'purchase_type' => 'one_time',
                'tags' => ['food-delivery', 'multi-vendor', 'rider-app', 'gps-tracking', 'marketplace'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1526367790999-0150786686a2?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Visual Workflow Automation Engine Blueprint',
                'slug' => 'visual-workflow-automation-blueprint',
                'description' => 'Self-hosted drag-and-drop workflow canvas with 30+ pre-built webhook triggers and fault-tolerant retry workers.',
                'detailed_description' => 'Self-hosted low-code workflow orchestration system similar to n8n and Zapier. Visual drag-and-drop node graph canvas, 30+ pre-built app integrations, cron schedules, webhook triggers, condition branching, and Redis queue workers with fault-tolerant retries.',
                'price' => 11499,
                'compare_price' => 17500,
                'stock' => 45,
                'digital' => true,
                'category' => 'AI & Automation',
                'product_kind' => 'digital_download',
                'purchase_type' => 'one_time',
                'tags' => ['automation', 'workflow', 'webhooks', 'node-canvas', 'zapier-alternative'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'ParkPulse 360™ - Smart Parking Management SaaS',
                'slug' => 'parkpulse-360-smart-parking',
                'description' => 'ANPR camera gate barrier, IoT parking occupancy, ticketless billing, and mobile parking space reservation.',
                'detailed_description' => 'Smart commercial and residential parking management platform. Supports automatic number plate recognition (ANPR) cameras, boom barrier controller integration, contactless RFID cards, dynamic hourly pricing, and mobile parking reservations.',
                'price' => 24999,
                'compare_price' => 35000,
                'stock' => 15,
                'digital' => true,
                'category' => 'Business Tools',
                'product_kind' => 'saas',
                'purchase_type' => 'monthly_subscription',
                'tags' => ['parking-management', 'iot', 'anpr', 'smart-city', 'saas', 'hardware-sync'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=900&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'BillVibe POS™ - Multi-Branch Retail Point of Sale',
                'slug' => 'billvibe-pos-retail-system',
                'description' => 'High-speed 0.2-second barcode checkout, offline transaction sync, and multi-warehouse inventory control.',
                'detailed_description' => 'Ultra-fast retail Point of Sale system with 0.2-second barcode scanning, thermal receipt printer integration, offline POS mode with automated background sync, multi-branch inventory transfers, customer loyalty discounts, and profit/loss reporting.',
                'price' => 14999,
                'compare_price' => 21000,
                'stock' => 50,
                'digital' => true,
                'category' => 'Business Tools',
                'product_kind' => 'saas',
                'purchase_type' => 'one_time',
                'tags' => ['pos', 'retail', 'barcode', 'inventory', 'thermal-printer', 'offline-first'],
                'featured' => true,
                'active' => true,
                'image_remote' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=900&auto=format&fit=crop&q=80',
            ],
        ];

        foreach ($flagships as $item) {
            $localFilename = $item['slug'] . '.jpg';
            $localPath = $storageDir . DIRECTORY_SEPARATOR . $localFilename;
            $dbPath = 'products/thumbnails/' . $localFilename;

            // Try downloading image if not existing
            if (!File::exists($localPath)) {
                try {
                    $context = stream_context_create([
                        'http' => [
                            'timeout' => 5,
                            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        ],
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                    ]);
                    $content = @file_get_contents($item['image_remote'], false, $context);
                    if ($content && strlen($content) > 1000) {
                        File::put($localPath, $content);
                    }
                } catch (\Throwable $e) {
                    // Fail silently, fallback to remote url
                }
            }

            // If local file exists, use local storage path; otherwise use direct high-res URL
            $thumbnailToStore = File::exists($localPath) ? $dbPath : $item['image_remote'];

            $productData = [
                'name' => $item['name'],
                'slug' => $item['slug'],
                'description' => $item['description'],
                'detailed_description' => $item['detailed_description'],
                'price' => $item['price'],
                'compare_price' => $item['compare_price'],
                'stock' => $item['stock'],
                'digital' => $item['digital'],
                'category' => $item['category'],
                'product_kind' => $item['product_kind'],
                'purchase_type' => $item['purchase_type'],
                'tags' => $item['tags'],
                'thumbnail' => $thumbnailToStore,
                'images' => [$thumbnailToStore],
                'featured' => $item['featured'],
                'active' => $item['active'],
                'published_at' => $now,
                'seo_title' => $item['name'] . ' | NextDigiHome Store',
                'seo_description' => Str::limit($item['description'], 160),
                'og_image' => $item['image_remote'],
            ];

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                $productData
            );
        }

        // Also ensure categories exist in categories table
        $categoriesToEnsure = [
            ['category_name' => 'Source Code', 'category_slug' => 'source-code'],
            ['category_name' => 'Mobile Apps', 'category_slug' => 'mobile-apps'],
            ['category_name' => 'AI & Automation', 'category_slug' => 'ai-automation'],
            ['category_name' => 'Business Tools', 'category_slug' => 'business-tools'],
        ];

        $adminId = \App\Models\User::first()?->id ?? 1;

        foreach ($categoriesToEnsure as $cat) {
            \App\Models\Category::firstOrCreate(
                ['category_slug' => $cat['category_slug']],
                ['category_name' => $cat['category_name'], 'status' => 1, 'created_by' => $adminId]
            );
        }
    }
}
