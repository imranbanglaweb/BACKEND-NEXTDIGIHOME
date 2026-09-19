<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Models\PageContent;
use App\Models\Product;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentManagementController extends Controller
{
    public function getHomeContent()
    {
        try {
            $data = [
                'hero_sliders' => HeroSlider::active()->ordered()->get(),
                'featured_products' => Product::where('active', true)
                    ->where('featured', true)
                    ->latest()
                    ->take(8)
                    ->get()
                    ->map(fn (Product $product) => $this->formatHomeProduct($product))
                    ->values(),
                'latest_products' => Product::where('active', true)
                    ->latest()
                    ->take(8)
                    ->get()
                    ->map(fn (Product $product) => $this->formatHomeProduct($product))
                    ->values(),
                'stats' => Stat::active()->ordered()->get(),
                'features' => PageContent::page('home')->section('features')->active()->ordered()->get(),
                'how_it_works' => PageContent::page('home')->section('how_it_works')->active()->ordered()->get(),
                'categories' => PageContent::page('home')->section('categories')->active()->ordered()->get(),
                'testimonials' => Testimonial::active()->ordered()->get(),
                'faq' => PageContent::page('home')->section('faq')->active()->ordered()->get(),
                'newsletter' => PageContent::page('home')->section('newsletter')->active()->first(),
                'enterprise_software' => $this->getEnterpriseSoftwareData(),
                'countries_worked' => $this->getCountriesWorkedData(),
                'global_pillars' => $this->getGlobalPillarsData(),
                'ecosystem_divisions' => $this->getEcosystemDivisionsData(),
                'methodology' => $this->getMethodologyData(),
                'trust_pillars' => $this->getTrustPillarsData(),
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'data' => [
                    'hero_sliders' => [],
                    'featured_products' => [],
                    'latest_products' => [],
                    'stats' => [],
                    'features' => [],
                    'how_it_works' => [],
                    'categories' => [],
                    'testimonials' => [],
                    'faq' => [],
                    'newsletter' => null,
                    'enterprise_software' => $this->getEnterpriseSoftwareData(),
                    'countries_worked' => $this->getCountriesWorkedData(),
                    'global_pillars' => $this->getGlobalPillarsData(),
                    'ecosystem_divisions' => $this->getEcosystemDivisionsData(),
                    'methodology' => $this->getMethodologyData(),
                    'trust_pillars' => $this->getTrustPillarsData(),
                ],
            ]);
        }
    }

    public function getAboutContent()
    {
        $data = [
            'mission' => PageContent::page('about')->section('mission')->active()->first(),
            'vision' => PageContent::page('about')->section('vision')->active()->first(),
            'stats' => PageContent::page('about')->section('stats')->active()->ordered()->get(),
            'team' => TeamMember::active()->ordered()->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function getContactContent()
    {
        $contactInfo = ContactInfo::active()->ordered()->get()->map(function ($info) {
            return [
                'id' => $info->id,
                'type' => $info->type,
                'label' => $info->title,
                'value' => $info->value,
                'description' => $info->description,
                'icon' => $info->icon,
            ];
        });

        $data = [
            'hero' => PageContent::page('contact')->section('hero')->active()->first(),
            'contact_info' => $contactInfo,
            'faq' => PageContent::page('contact')->section('faq')->active()->ordered()->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function getPrivacyContent()
    {
        $content = PageContent::page('privacy')->section('content')->active()->first();

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    public function getTermsContent()
    {
        $content = PageContent::page('terms')->section('content')->active()->first();

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    public function getRefundContent()
    {
        $content = PageContent::page('refund')->section('content')->active()->first();

        return response()->json([
            'success' => true,
            'data' => $content,
        ]);
    }

    public function getSolutionsContent()
    {
        $hero = PageContent::page('solutions')->section('hero')->active()->first();
        $sections = PageContent::page('solutions')->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'sections' => $sections,
            ],
        ]);
    }

    public function getAiContent()
    {
        $hero = PageContent::page('ai')->section('hero')->active()->first();
        $sections = PageContent::page('ai')->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'sections' => $sections,
            ],
        ]);
    }

    public function getGrowthContent()
    {
        $hero = PageContent::page('growth')->section('hero')->active()->first();
        $sections = PageContent::page('growth')->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'sections' => $sections,
            ],
        ]);
    }

    public function getLabsContent()
    {
        $hero = PageContent::page('labs')->section('hero')->active()->first();
        $sections = PageContent::page('labs')->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => $hero,
                'sections' => $sections,
            ],
        ]);
    }

    public function getCaseStudiesContent()
    {
        $sections = PageContent::page('case-studies')->active()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'sections' => $sections,
            ],
        ]);
    }

    public function getAllContent()
    {
        $data = [
            'hero_sliders' => HeroSlider::all(),
            'featured_products' => Product::where('active', true)
                ->where('featured', true)
                ->latest()
                ->take(8)
                ->get()
                ->map(fn (Product $product) => $this->formatHomeProduct($product))
                ->values(),
            'page_contents' => PageContent::all(),
            'stats' => Stat::all(),
            'testimonials' => Testimonial::all(),
            'team_members' => TeamMember::all(),
            'contact_info' => ContactInfo::all(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    protected function formatHomeProduct(Product $product): array
    {
        $thumbnailUrl = $this->resolveProductAssetUrl($product->thumbnail);
        $description = trim(strip_tags((string) ($product->description ?: $product->detailed_description)));

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => Str::limit($description, 140),
            'price' => $product->price,
            'compare_price' => $product->compare_price,
            'category' => $product->category,
            'featured' => (bool) $product->featured,
            'thumbnail' => $product->thumbnail,
            'thumbnail_url' => $thumbnailUrl,
            'image_url' => $thumbnailUrl,
            'image_alt' => $product->name,
            'image_display' => [
                'width' => 900,
                'height' => 675,
                'aspect_ratio' => '4/3',
                'object_fit' => 'cover',
                'sizes' => '(max-width: 640px) 86vw, (max-width: 1024px) 42vw, 320px',
                'container' => [
                    'width' => '100%',
                    'max_width' => '360px',
                    'min_width' => '0',
                ],
            ],
            'seo' => [
                'title' => $product->seo_title ?: $product->name,
                'description' => $product->seo_description ?: Str::limit($description, 160, ''),
                'canonical_url' => $product->canonical_url ?: url('/products/'.$product->slug),
            ],
        ];
    }

    protected function resolveProductAssetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        return asset('public/storage/'.ltrim($path, '/'));
    }

    public function getEnterpriseSoftware()
    {
        return response()->json([
            'success' => true,
            'data' => $this->getEnterpriseSoftwareData(),
        ]);
    }

    public function getGlobalReach()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'countries_worked' => $this->getCountriesWorkedData(),
                'pillars' => $this->getGlobalPillarsData(),
            ],
        ]);
    }

    public function getDivisions()
    {
        return response()->json([
            'success' => true,
            'data' => $this->getEcosystemDivisionsData(),
        ]);
    }

    protected function getEnterpriseSoftwareData(): array
    {
        try {
            $contents = PageContent::page('home')->section('enterprise_software')->active()->ordered()->get();
            if ($contents->isNotEmpty()) {
                return $contents->map(function ($item) {
                    $meta = is_array($item->metadata) ? $item->metadata : (json_decode($item->metadata, true) ?: []);
                    return [
                        'id' => $meta['id'] ?? Str::slug($item->title),
                        'name' => $item->title,
                        'categoryTag' => $meta['categoryTag'] ?? 'Enterprise Software',
                        'categoryFilter' => $meta['categoryFilter'] ?? 'mobility',
                        'tagline' => $item->subtitle ?: ($meta['tagline'] ?? ''),
                        'badge' => $meta['badge'] ?? 'Enterprise Ready',
                        'badgeColor' => $meta['badgeColor'] ?? 'bg-[#00d4aa]/15 text-[#00d4aa] border-[#00d4aa]/30',
                        'description' => $item->content ?: '',
                        'highlights' => $meta['highlights'] ?? [],
                        'techStack' => $meta['techStack'] ?? [],
                        'deploymentOptions' => $meta['deploymentOptions'] ?? ['Cloud SaaS', 'Self-Hosted'],
                        'color' => $meta['color'] ?? '#00d4aa',
                        'glowColor' => $meta['glowColor'] ?? 'rgba(0, 212, 170, 0.35)',
                        'icon' => $meta['icon'] ?? 'CommandLineIcon',
                        'liveUrl' => $meta['liveUrl'] ?? null,
                        'ctaText' => $meta['ctaText'] ?? 'Explore Solution',
                    ];
                })->values()->all();
            }
        } catch (\Exception $e) {}

        return [
            [
                'id' => 'parking-software',
                'name' => 'ParkPulse 360™',
                'categoryTag' => 'Smart Mobility & ANPR',
                'categoryFilter' => 'mobility',
                'tagline' => 'Automated Smart Parking & ANPR Barrier Management',
                'badge' => 'Hardware & IoT Ready',
                'badgeColor' => 'bg-[#00d4aa]/15 text-[#00d4aa] border-[#00d4aa]/30',
                'description' => 'High-accuracy Automatic Number Plate Recognition (ANPR) linked with automatic boom barrier gates, live multi-level vacancy sensors, and QR cashless payment checkout.',
                'highlights' => [
                    'Sub-second ANPR Camera Plate Recognition & Barrier Trigger',
                    'Live Slot Occupancy Telemetry with Dynamic Overhead LED Map',
                    'Hourly, Daily, VIP Resident & Corporate Fleet Pass Billing',
                    'Cashless Checkout via bKash, Cards, Stripe, and POS Thermal Print',
                    'Blacklisted Plate Security Alerts & Real-time Revenue Audit Logs'
                ],
                'techStack' => ['Next.js 16', 'Python ANPR', 'Node.js IoT', 'PostgreSQL', 'MQTT WebSockets'],
                'deploymentOptions' => ['Cloud Central SaaS', 'Local Offline Appliance', 'Hybrid Gateway'],
                'color' => '#00d4aa',
                'glowColor' => 'rgba(0, 212, 170, 0.35)',
                'icon' => 'TruckIcon',
                'ctaText' => 'Explore ParkPulse'
            ],
            [
                'id' => 'lan-management',
                'name' => 'NetShield LAN™',
                'categoryTag' => 'Network Ops & Cybersecurity',
                'categoryFilter' => 'network',
                'tagline' => 'Enterprise LAN, ISP & Bandwidth Infrastructure Controller',
                'badge' => 'ISP & Enterprise Ready',
                'badgeColor' => 'bg-[#38bdf8]/15 text-[#38bdf8] border-[#38bdf8]/30',
                'description' => 'Centralized network orchestration console with automated Mikrotik & Cisco router scripting, dynamic bandwidth rate shaping, subscriber billing, and SMS OTP captive voucher portal.',
                'highlights' => [
                    'Mikrotik RouterOS & Cisco API Auto-Provisioning & Scripting',
                    'Dynamic Speed Throttling, Fair-Usage Policy (FUP) & Quota Limits',
                    'Captive Portal Hotspot with SMS OTP Voucher Generation & Token Billing',
                    'Live Visual Network Topology Map & Ping Packet Drop Alert Webhooks',
                    'MAC Address Binding, ARP Anti-Spoofing & IP Pool Firewall Routing'
                ],
                'techStack' => ['Node.js API', 'Mikrotik API', 'Redis Cache', 'WebSockets', 'Tailwind'],
                'deploymentOptions' => ['On-Premise Server', 'Cloud Central Controller', 'Docker Cluster'],
                'color' => '#38bdf8',
                'glowColor' => 'rgba(56, 189, 248, 0.35)',
                'icon' => 'ServerIcon',
                'ctaText' => 'Explore NetShield'
            ],
            [
                'id' => 'hrms-solution',
                'name' => 'WorkZen HRMS™',
                'categoryTag' => 'Human Capital & Smart Payroll',
                'categoryFilter' => 'hrms',
                'tagline' => 'Enterprise Cloud Human Resource & Automated Payroll Suite',
                'badge' => 'Multi-Tenant Cloud',
                'badgeColor' => 'bg-[#8b5cf6]/15 text-[#8b5cf6] border-[#8b5cf6]/30',
                'description' => 'Complete employee lifecycle management combining real-time biometric attendance capture, automated progressive tax & salary disbursement, shift rosters, and mobile self-service.',
                'highlights' => [
                    'ZKTeco & Face/Fingerprint Device Real-Time Attendance Sync',
                    '1-Click Salary Disbursement, Bank Advice Files & PDF Pay Slips',
                    'Multi-Level Leave Approval Hierarchy & Dynamic Shift Roster Engine',
                    'Employee Self-Service (ESS) Mobile Portal with Geo-Fenced Check-in',
                    'Tax Deduction Slabs, Provident Fund Ledgers & Expense Claims Audit'
                ],
                'techStack' => ['Next.js 16', 'React 19', 'Express Backend', 'PostgreSQL', 'Docker'],
                'deploymentOptions' => ['Cloud Multi-Tenant', 'Self-Hosted Private VPC', 'Enterprise License'],
                'color' => '#8b5cf6',
                'glowColor' => 'rgba(139, 92, 246, 0.35)',
                'icon' => 'UserGroupIcon',
                'ctaText' => 'Explore WorkZen'
            ],
            [
                'id' => 'school-management',
                'name' => 'EduSphere 360™',
                'categoryTag' => 'EdTech & Campus ERP',
                'categoryFilter' => 'edtech',
                'tagline' => 'All-in-One Smart School, College & Campus Operating System',
                'badge' => 'K-12 & University Ready',
                'badgeColor' => 'bg-[#f59e0b]/15 text-[#f59e0b] border-[#f59e0b]/30',
                'description' => 'Unified institutional operating platform unifying online admissions, fee collections, GPA examination tabulation, printable student ID cards, and automated parent SMS alerts.',
                'highlights' => [
                    'Digital Admission Portal with Automated Barcode Student ID Printing',
                    'Multi-Gateway Tuition Fee Collection (bKash/Cards) & Auto-Receipts',
                    'GPA/CGPA Grading Matrix, Tabulation Sheets & Terminal Report Cards',
                    'RFID Gate Attendance with Instant Parent Entry/Exit Push Alerts',
                    'Teacher Gradebook, Digital Library, Hostel & School Bus GPS Fleet'
                ],
                'techStack' => ['Next.js', 'React', 'Node.js', 'MySQL', 'SMS Gateway API'],
                'deploymentOptions' => ['Institutional SaaS', 'School Private Server', 'Full Source Code'],
                'color' => '#f59e0b',
                'glowColor' => 'rgba(245, 158, 11, 0.35)',
                'icon' => 'AcademicCapIcon',
                'ctaText' => 'Explore EduSphere'
            ],
            [
                'id' => 'customer-cms',
                'name' => 'OmniFlow CMS™',
                'categoryTag' => 'Digital Experience & Headless CMS',
                'categoryFilter' => 'cms',
                'tagline' => 'Headless Digital Experience & Customer Content Engine',
                'badge' => 'API-First & Edge Ready',
                'badgeColor' => 'bg-[#f43f5e]/15 text-[#f43f5e] border-[#f43f5e]/30',
                'description' => 'Modern API-first content management system designed for speed, flexibility, and customer conversions with drag-and-drop block building and dynamic lead capture.',
                'highlights' => [
                    'Visual Drag-and-Drop Page Builder & Modular Block Composer',
                    'Headless REST & GraphQL APIs Serving Web, iOS & Android Frontends',
                    'Dynamic Customer Form Builder with Automated CRM Webhook Routing',
                    'Multi-Language Localization, Dynamic Slugs & Automated SEO Schema',
                    'Granular Role-Based Access Control (Author, Editor, Admin, Publisher)'
                ],
                'techStack' => ['Next.js 16', 'TypeScript', 'Tailwind CSS', 'PostgreSQL', 'Prisma'],
                'deploymentOptions' => ['Vercel Edge Cloud', 'Self-Hosted Docker', 'Enterprise Whitelabel'],
                'color' => '#f43f5e',
                'glowColor' => 'rgba(244, 63, 94, 0.35)',
                'icon' => 'CommandLineIcon',
                'ctaText' => 'Explore OmniFlow'
            ],
            [
                'id' => 'garibondhu-erp',
                'name' => 'Garibondhu360™',
                'categoryTag' => 'Automotive & Workshop ERP',
                'categoryFilter' => 'hrms',
                'tagline' => 'Automotive Repair, Garage & Workshop Operating Platform',
                'badge' => 'Active Live SaaS',
                'badgeColor' => 'bg-[#10b981]/15 text-[#10b981] border-[#10b981]/30',
                'description' => 'Leading workshop operating system with digital job cards, camera vehicle condition intake, barcode spare parts stock, and technician commission tracking.',
                'highlights' => [
                    'Digital Vehicle Inspection Checklist with Camera Damage Photo Logs',
                    'Barcode Spare-Parts Inventory with Minimum Stock Auto-Reorder Alerts',
                    'Technician Work-Order Allocation & Automated Commission Calculation',
                    'Automated Customer SMS Delivery Estimates & Digital PDF Invoices'
                ],
                'techStack' => ['Next.js', 'Node.js', 'PostgreSQL', 'Docker', 'SMS Gateway'],
                'deploymentOptions' => ['Active Cloud SaaS', 'Dedicated Workshop Appliance'],
                'color' => '#10b981',
                'glowColor' => 'rgba(16, 185, 129, 0.35)',
                'icon' => 'WrenchScrewdriverIcon',
                'liveUrl' => 'https://garibondhu360.nextdigihome.com/',
                'ctaText' => 'Launch Garibondhu360'
            ],
            [
                'id' => 'medicore-health',
                'name' => 'MediCore Health™',
                'categoryTag' => 'Healthcare & Clinical ERP',
                'categoryFilter' => 'cms',
                'tagline' => 'Hospital, Clinic & Patient Practice Management System',
                'badge' => 'Clinic & Hospital Ready',
                'badgeColor' => 'bg-[#06b6d4]/15 text-[#06b6d4] border-[#06b6d4]/30',
                'description' => 'Secure clinical management ecosystem covering patient electronic health records (EHR), multi-doctor scheduling, diagnostic laboratory reporting, and pharmacy billing.',
                'highlights' => [
                    'Electronic Medical Records (EMR) & Digital Prescription Generator',
                    'Doctor Roster Scheduling & Multi-Channel Patient Online Booking',
                    'Diagnostic Pathology & Radiology Test Reporting with Barcode Tracking',
                    'Inpatient Bed/Cabin Management & Integrated Pharmacy POS Dispensing'
                ],
                'techStack' => ['Next.js 16', 'Node.js API', 'PostgreSQL', 'HIPAA Standards'],
                'deploymentOptions' => ['Private Healthcare Cloud', 'Hospital On-Premise LAN'],
                'color' => '#06b6d4',
                'glowColor' => 'rgba(6, 182, 212, 0.35)',
                'icon' => 'ShieldCheckIcon',
                'ctaText' => 'Explore MediCore'
            ],
            [
                'id' => 'billvibe-pos',
                'name' => 'BillVibe POS™',
                'categoryTag' => 'Retail & Multi-Branch POS',
                'categoryFilter' => 'cms',
                'tagline' => 'High-Speed Cloud Point of Sale & Centralized Inventory',
                'badge' => 'Multi-Branch & Retail Ready',
                'badgeColor' => 'bg-[#ec4899]/15 text-[#ec4899] border-[#ec4899]/30',
                'description' => 'Lightning-fast 0.2-second barcode checkout system with offline transaction resilience, multi-branch centralized warehouse sync, and customer loyalty rewards.',
                'highlights' => [
                    'Sub-Second Barcode Scanning & Thermal Receipt Printer Integration',
                    'Multi-Branch Real-Time Inventory Sync & Inter-Store Stock Transfers',
                    'Customer Loyalty Points, Dynamic Discount Coupons & SMS Invoices',
                    'Real-Time Gross Margin & Profit/Loss Analytics Dashboard'
                ],
                'techStack' => ['React', 'PWA / Electron', 'SQLite / Cloud Sync', 'Thermal API'],
                'deploymentOptions' => ['Cloud Sync SaaS', 'Offline-First Desktop / Touch Terminal'],
                'color' => '#ec4899',
                'glowColor' => 'rgba(236, 72, 153, 0.35)',
                'icon' => 'ShoppingBagIcon',
                'ctaText' => 'Explore BillVibe'
            ],
        ];
    }

    protected function getCountriesWorkedData(): array
    {
        try {
            $contents = PageContent::page('home')->section('countries_worked')->active()->ordered()->get();
            if ($contents->isNotEmpty()) {
                return $contents->map(function ($item) {
                    $meta = is_array($item->metadata) ? $item->metadata : (json_decode($item->metadata, true) ?: []);
                    return [
                        'id' => $meta['id'] ?? strtolower($item->content ?: $item->title),
                        'name' => $meta['name'] ?? $item->title,
                        'flagUrl' => $meta['flagUrl'] ?? ('/flags/' . strtolower($meta['id'] ?? 'us') . '.svg'),
                        'code' => $meta['code'] ?? strtoupper($item->content ?: 'US'),
                    ];
                })->values()->all();
            }
        } catch (\Exception $e) {}

        return [
            ['id' => 'us', 'name' => 'United States', 'flagUrl' => '/flags/us.svg', 'code' => 'US'],
            ['id' => 'uk', 'name' => 'United Kingdom', 'flagUrl' => '/flags/gb.svg', 'code' => 'GB'],
            ['id' => 'ca', 'name' => 'Canada', 'flagUrl' => '/flags/ca.svg', 'code' => 'CA'],
            ['id' => 'au', 'name' => 'Australia', 'flagUrl' => '/flags/au.svg', 'code' => 'AU'],
            ['id' => 'de', 'name' => 'Germany', 'flagUrl' => '/flags/de.svg', 'code' => 'DE'],
            ['id' => 'ae', 'name' => 'United Arab Emirates', 'flagUrl' => '/flags/ae.svg', 'code' => 'AE'],
            ['id' => 'sa', 'name' => 'Saudi Arabia', 'flagUrl' => '/flags/sa.svg', 'code' => 'SA'],
            ['id' => 'sg', 'name' => 'Singapore', 'flagUrl' => '/flags/sg.svg', 'code' => 'SG'],
            ['id' => 'in', 'name' => 'India', 'flagUrl' => '/flags/in.svg', 'code' => 'IN'],
            ['id' => 'pk', 'name' => 'Pakistan', 'flagUrl' => '/flags/pk.svg', 'code' => 'PK'],
            ['id' => 'bd', 'name' => 'Bangladesh', 'flagUrl' => '/flags/bd.svg', 'code' => 'BD'],
            ['id' => 'my', 'name' => 'Malaysia', 'flagUrl' => '/flags/my.svg', 'code' => 'MY'],
        ];
    }

    protected function getGlobalPillarsData(): array
    {
        try {
            $contents = PageContent::page('home')->section('global_pillars')->active()->ordered()->get();
            if ($contents->isNotEmpty()) {
                return $contents->map(function ($item) {
                    $meta = is_array($item->metadata) ? $item->metadata : (json_decode($item->metadata, true) ?: []);
                    return [
                        'stat' => $item->subtitle ?: ($meta['stat'] ?? ''),
                        'title' => $item->title,
                        'desc' => $item->content ?: '',
                        'color' => $meta['color'] ?? '#00d4aa',
                        'icon' => $meta['icon'] ?? 'ShieldCheckIcon',
                    ];
                })->values()->all();
            }
        } catch (\Exception $e) {}

        return [
            [
                'stat' => '100%',
                'title' => 'Client IP Ownership',
                'desc' => 'Full GitHub repository handover with zero vendor lock-in & strict mutual NDA.',
                'color' => '#00d4aa',
                'icon' => 'ShieldCheckIcon',
            ],
            [
                'stat' => '24/7',
                'title' => 'Multi-Timezone Sprints',
                'desc' => 'Dedicated overlap across North America (EST/PST), UK, Middle East & Asia hours.',
                'color' => '#38bdf8',
                'icon' => 'ClockIcon',
            ],
            [
                'stat' => 'Multi-Currency',
                'title' => 'Cross-Border Invoicing',
                'desc' => 'Seamless invoicing in USD, GBP, EUR, AED, and BDT via Stripe & Wire Transfer.',
                'color' => '#8b5cf6',
                'icon' => 'ArrowsRightLeftIcon',
            ],
            [
                'stat' => '99.98%',
                'title' => 'Enterprise Cloud SLA',
                'desc' => 'Low-latency global edge deployment backed by AWS, Vercel & Cloudflare.',
                'color' => '#10b981',
                'icon' => 'ServerIcon',
            ],
        ];
    }

    protected function getEcosystemDivisionsData(): array
    {
        try {
            $contents = PageContent::page('home')->section('ecosystem_divisions')->active()->ordered()->get();
            if ($contents->isNotEmpty()) {
                return $contents->map(function ($item) {
                    $meta = is_array($item->metadata) ? $item->metadata : (json_decode($item->metadata, true) ?: []);
                    return [
                        'id' => $meta['id'] ?? Str::slug($item->title),
                        'name' => $item->title,
                        'shortName' => $meta['shortName'] ?? $item->title,
                        'tagline' => $item->subtitle ?: '',
                        'desc' => $item->content ?: '',
                        'badge' => $meta['badge'] ?? '',
                        'color' => $meta['color'] ?? '#00d4aa',
                        'accentColor' => $meta['accentColor'] ?? '#38bdf8',
                        'glowColor' => $meta['glowColor'] ?? 'rgba(0, 212, 170, 0.5)',
                        'metric' => $meta['metric'] ?? '',
                        'href' => $meta['href'] ?? '/solutions',
                    ];
                })->values()->all();
            }
        } catch (\Exception $e) {}

        return [
            [
                'id' => 'solutions',
                'name' => 'NextDigi Solutions',
                'shortName' => 'Solutions',
                'tagline' => 'Technology & Software Development',
                'desc' => 'Custom SaaS platforms, Next.js 16 web applications, cloud backends, and full-stack architectures.',
                'badge' => 'Web & SaaS',
                'color' => '#00d4aa',
                'accentColor' => '#38bdf8',
                'glowColor' => 'rgba(0, 212, 170, 0.5)',
                'metric' => '18ms Edge Latency • 100% Client IP',
                'href' => '/solutions',
            ],
            [
                'id' => 'ai',
                'name' => 'NextDigi AI',
                'shortName' => 'NextDigi AI',
                'tagline' => 'AI & Autonomous Automation',
                'desc' => 'Autonomous agentic workflows, private RAG knowledge bases, WhatsApp bots, and CRM auto-dispatch.',
                'badge' => 'AI & Agents',
                'color' => '#8b5cf6',
                'accentColor' => '#c084fc',
                'glowColor' => 'rgba(139, 92, 246, 0.5)',
                'metric' => 'Multi-Model LLM • WhatsApp API 24/7',
                'href' => '/ai',
            ],
            [
                'id' => 'growth',
                'name' => 'NextDigi Growth',
                'shortName' => 'Growth',
                'tagline' => 'Digital Marketing & Growth',
                'desc' => 'Server-side CAPI tracking, Meta & Google Performance Max ads, Technical SEO, and automated retargeting.',
                'badge' => 'Growth & Ads',
                'color' => '#10b981',
                'accentColor' => '#34d399',
                'glowColor' => 'rgba(16, 185, 129, 0.5)',
                'metric' => '4.6x Average ROAS • 99.4% Match Rate',
                'href' => '/growth',
            ],
            [
                'id' => 'labs',
                'name' => 'NextDigi Labs',
                'shortName' => 'NextDigi Labs',
                'tagline' => 'SaaS & Proprietary Products',
                'desc' => 'Flagship software products including NextDigi Commerce and Garibondhu360 automotive platform.',
                'badge' => 'SaaS Products',
                'color' => '#f59e0b',
                'accentColor' => '#fbbf24',
                'glowColor' => 'rgba(245, 158, 11, 0.5)',
                'metric' => 'Commerce & Garibondhu360 Live',
                'href' => '/labs',
            ],
            [
                'id' => 'store',
                'name' => 'NextDigi Store',
                'shortName' => 'NextDigi Store',
                'tagline' => 'Digital Assets & Templates',
                'desc' => 'Curated marketplace of production source codes, mobile app templates, ERP scripts, and business tools.',
                'badge' => 'Digital Assets',
                'color' => '#f43f5e',
                'accentColor' => '#fb7185',
                'glowColor' => 'rgba(244, 63, 94, 0.5)',
                'metric' => 'Instant Download • Verified Clean Code',
                'href' => '/store',
            ],
            [
                'id' => 'cloud',
                'name' => 'NextDigi Cloud & Security',
                'shortName' => 'Cloud & IP',
                'tagline' => 'Enterprise Infrastructure & IP',
                'desc' => 'PostgreSQL Row-Level Security (RLS), multi-region Edge CDN delivery, and full client IP ownership protection.',
                'badge' => 'Edge & Security',
                'color' => '#0284c7',
                'accentColor' => '#6366f1',
                'glowColor' => 'rgba(2, 132, 199, 0.5)',
                'metric' => '100% Code Ownership • 99.98% SLA',
                'href' => '/solutions',
            ],
        ];
    }

    protected function getMethodologyData(): array
    {
        try {
            $contents = PageContent::page('home')->section('methodology')->active()->ordered()->get();
            if ($contents->isNotEmpty()) {
                return $contents->map(function ($item) {
                    $meta = is_array($item->metadata) ? $item->metadata : (json_decode($item->metadata, true) ?: []);
                    return [
                        'step' => $meta['step'] ?? sprintf('%02d', $item->sort_order),
                        'title' => $item->title,
                        'subtitle' => $item->subtitle ?: '',
                        'desc' => $item->content ?: '',
                    ];
                })->values()->all();
            }
        } catch (\Exception $e) {}

        return [
            ['step' => '01', 'title' => 'BUILD', 'subtitle' => 'Plan → Design → Develop', 'desc' => 'Requirements scoping, database modeling, and agile software development with modern TypeScript frameworks.'],
            ['step' => '02', 'title' => 'LAUNCH', 'subtitle' => 'Test → Deploy → Integrate', 'desc' => 'Comprehensive testing, automated CI/CD deployment pipelines, and zero-downtime production cutover.'],
            ['step' => '03', 'title' => 'AUTOMATE', 'subtitle' => 'AI → Workflow → Operations', 'desc' => 'Deploying autonomous AI agents, API webhooks, and event pipelines to eliminate manual bottlenecks.'],
            ['step' => '04', 'title' => 'GROW', 'subtitle' => 'Marketing → Analytics → Optimization', 'desc' => 'Data-driven advertising, conversion rate optimization, technical SEO, and scaling customer acquisition.'],
        ];
    }

    protected function getTrustPillarsData(): array
    {
        try {
            $contents = PageContent::page('home')->section('why_choose_us')->active()->ordered()->get();
            if ($contents->isNotEmpty()) {
                return $contents->map(function ($item) {
                    $meta = is_array($item->metadata) ? $item->metadata : (json_decode($item->metadata, true) ?: []);
                    return [
                        'title' => $item->title,
                        'desc' => $item->content ?: '',
                        'icon' => $meta['icon'] ?? 'CommandLineIcon',
                    ];
                })->values()->all();
            }
        } catch (\Exception $e) {}

        return [
            ['title' => 'End-to-End Technology', 'desc' => 'From custom web and mobile platforms to cloud APIs, we deliver complete turn-key solutions under one roof.', 'icon' => 'CommandLineIcon'],
            ['title' => 'Custom Solutions', 'desc' => 'Every application is tailored to your business model with complete 100% intellectual property ownership transfer.', 'icon' => 'ShieldCheckIcon'],
            ['title' => 'AI & Automation', 'desc' => 'Deterministic AI agents and connected webhook pipelines that streamline repetitive operations and save overhead.', 'icon' => 'CpuChipIcon'],
            ['title' => 'SaaS Development', 'desc' => 'Multi-tenant database design, automated subscription recurring billing, and scalable edge deployment architectures.', 'icon' => 'ServerIcon'],
            ['title' => 'Enterprise SLA', 'desc' => 'Low-latency global edge deployment backed by AWS, Vercel & Cloudflare with continuous monitoring and zero downtime.', 'icon' => 'BoltIcon'],
            ['title' => 'Transparent Handover', 'desc' => 'Full GitHub repository handover, documentation, clean modular codebases, and zero vendor lock-in.', 'icon' => 'CodeBracketIcon'],
        ];
    }
}
