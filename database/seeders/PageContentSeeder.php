<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Home page content
            [
                'page' => 'home',
                'section' => 'mission',
                'title' => 'Our Mission',
                'content' => 'To empower modern businesses with high-performance software engineering, autonomous AI workflows, predictable customer acquisition, and production-grade SaaS platforms.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'features',
                'title' => 'Full-Cycle Engineering',
                'subtitle' => 'Modern Architecture',
                'content' => 'From headless Next.js storefronts to high-concurrency microservices, we build software designed for enterprise scale and speed.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'features',
                'title' => 'Autonomous AI Workflows',
                'subtitle' => 'Intelligent Agents',
                'content' => 'Deploy task agents, custom RAG knowledge bases, and conversational AI chatbots that reduce operational overhead by up to 80%.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'features',
                'title' => '24/7 SLA Engineering',
                'subtitle' => 'Enterprise Reliability',
                'content' => 'Continuous monitoring, high-availability cloud deployments, and dedicated DevOps support to guarantee 99.9% platform uptime.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'how_it_works',
                'title' => '1. Discovery & Strategy',
                'content' => 'We analyze your business architecture, identify automation bottlenecks, and engineer a bespoke product and technical roadmap.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'how_it_works',
                'title' => '2. Rapid Production & Build',
                'content' => 'Iterative sprint releases with clean code, modern tech stacks (Next.js, Flutter, Laravel, Python AI), and comprehensive testing.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'how_it_works',
                'title' => '3. Launch, Automate & Scale',
                'content' => 'Zero-downtime deployment, automated customer acquisition funnels, and continuous SLA support to scale revenue.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'faq',
                'title' => 'What services does the NextDigiHome ecosystem provide?',
                'content' => 'NextDigiHome operates 4 integrated divisions: NextDigi Solutions (Software & Web Engineering), NextDigi AI (Agents & Intelligent RPA), NextDigi Growth (Performance Marketing & SEO), and NextDigi Labs (Proprietary SaaS platforms).',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'faq',
                'title' => 'Who owns the intellectual property and code?',
                'content' => 'You retain 100% full ownership of all custom code, assets, repositories, and intellectual property developed for your project upon final handover.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'section' => 'newsletter',
                'title' => 'Join the NextDigiHome Ecosystem Dispatch',
                'subtitle' => 'Get actionable engineering insights, AI automation playbooks, and SaaS growth strategies delivered weekly.',
                'link_text' => 'Subscribe Now',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // About page content
            [
                'page' => 'about',
                'section' => 'mission',
                'title' => 'Our Mission',
                'content' => 'To accelerate business potential by unifying custom software engineering, generative AI automation, predictable customer acquisition, and enterprise-grade SaaS technology under one cohesive ecosystem.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'about',
                'section' => 'vision',
                'title' => 'Our Vision',
                'content' => 'To be the premier end-to-end technology partner for modern global enterprises, empowering digital transformation with unwavering execution velocity and engineering integrity.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Contact page content
            [
                'page' => 'contact',
                'section' => 'hero',
                'title' => 'Start Your Next Technical Milestone',
                'content' => 'Discuss your next software build, autonomous AI workflow, or digital growth campaign with our senior solutions team.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Solutions Division content
            [
                'page' => 'solutions',
                'section' => 'hero',
                'title' => 'NextDigi Solutions',
                'subtitle' => 'Full-Cycle Engineering & Architecture',
                'content' => 'High-performance web applications, headless ecommerce, Flutter mobile apps, enterprise ERPs, and cloud SaaS infrastructure engineered for speed, security, and scale.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // AI Division content
            [
                'page' => 'ai',
                'section' => 'hero',
                'title' => 'NextDigi AI & Automation',
                'subtitle' => 'Autonomous Intelligence & RPA',
                'content' => 'Deploy autonomous task agents, custom RAG chatbots, multi-channel customer service bots, and zero-touch API pipelines to multiply team productivity.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Growth Division content
            [
                'page' => 'growth',
                'section' => 'hero',
                'title' => 'NextDigi Growth',
                'subtitle' => 'Performance Marketing & Customer Acquisition',
                'content' => 'Engineered customer acquisition across Meta Ads, Google Search, programmatic SEO, and full-funnel conversion telemetry.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Labs Division content
            [
                'page' => 'labs',
                'section' => 'hero',
                'title' => 'NextDigi Labs',
                'subtitle' => 'Proprietary SaaS Platforms',
                'content' => 'Active production software platforms including NextDigi Commerce, NextDigi Social, NextDigi Automate, and Garibondhu360 Transport SaaS.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Refund Policy content
            [
                'page' => 'refund',
                'section' => 'content',
                'title' => 'Refund Policy',
                'content' => 'At NextDigiHome, customer satisfaction and engineering excellence are our top priorities. Custom development services adhere to milestone acceptance criteria, while digital marketplace purchases qualify for refunds if technical defects are verified within 14 days of purchase.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Privacy page content
            [
                'page' => 'privacy',
                'section' => 'content',
                'title' => 'Privacy Policy',
                'content' => 'This Privacy Policy describes how NextDigiHome collects, uses, and protects your personal information and project data when you use our website, services, and software platforms.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // Terms page content
            [
                'page' => 'terms',
                'section' => 'content',
                'title' => 'Terms of Service',
                'content' => 'These Terms of Service govern your use of the NextDigiHome ecosystem, platforms, and services. By accessing our services, you agree to these terms.',
                'sort_order' => 1,
                'is_active' => true,
            ],

            // =========================================================================
            // ENTERPRISE SOFTWARE & INDUSTRY PLATFORMS (Dynamic Homepage Showcase)
            // =========================================================================
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'ParkPulse 360™',
                'subtitle' => 'Automated Smart Parking & ANPR Barrier Management',
                'content' => 'High-accuracy Automatic Number Plate Recognition (ANPR) linked with automatic boom barrier gates, live multi-level vacancy sensors, and QR cashless payment checkout.',
                'sort_order' => 1,
                'is_active' => true,
                'metadata' => [
                    'id' => 'parking-software',
                    'categoryTag' => 'Smart Mobility & ANPR',
                    'categoryFilter' => 'mobility',
                    'badge' => 'Hardware & IoT Ready',
                    'badgeColor' => 'bg-[#00d4aa]/15 text-[#00d4aa] border-[#00d4aa]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'NetShield LAN™',
                'subtitle' => 'Enterprise LAN, ISP & Bandwidth Infrastructure Controller',
                'content' => 'Centralized network orchestration console with automated Mikrotik & Cisco router scripting, dynamic bandwidth rate shaping, subscriber billing, and SMS OTP captive voucher portal.',
                'sort_order' => 2,
                'is_active' => true,
                'metadata' => [
                    'id' => 'lan-management',
                    'categoryTag' => 'Network Ops & Cybersecurity',
                    'categoryFilter' => 'network',
                    'badge' => 'ISP & Enterprise Ready',
                    'badgeColor' => 'bg-[#38bdf8]/15 text-[#38bdf8] border-[#38bdf8]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'WorkZen HRMS™',
                'subtitle' => 'Enterprise Cloud Human Resource & Automated Payroll Suite',
                'content' => 'Complete employee lifecycle management combining real-time biometric attendance capture, automated progressive tax & salary disbursement, shift rosters, and mobile self-service.',
                'sort_order' => 3,
                'is_active' => true,
                'metadata' => [
                    'id' => 'hrms-solution',
                    'categoryTag' => 'Human Capital & Smart Payroll',
                    'categoryFilter' => 'hrms',
                    'badge' => 'Multi-Tenant Cloud',
                    'badgeColor' => 'bg-[#8b5cf6]/15 text-[#8b5cf6] border-[#8b5cf6]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'EduSphere 360™',
                'subtitle' => 'All-in-One Smart School, College & Campus Operating System',
                'content' => 'Unified institutional operating platform unifying online admissions, fee collections, GPA examination tabulation, printable student ID cards, and automated parent SMS alerts.',
                'sort_order' => 4,
                'is_active' => true,
                'metadata' => [
                    'id' => 'school-management',
                    'categoryTag' => 'EdTech & Campus ERP',
                    'categoryFilter' => 'edtech',
                    'badge' => 'K-12 & University Ready',
                    'badgeColor' => 'bg-[#f59e0b]/15 text-[#f59e0b] border-[#f59e0b]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'OmniFlow CMS™',
                'subtitle' => 'Headless Digital Experience & Customer Content Engine',
                'content' => 'Modern API-first content management system designed for speed, flexibility, and customer conversions with drag-and-drop block building and dynamic lead capture.',
                'sort_order' => 5,
                'is_active' => true,
                'metadata' => [
                    'id' => 'customer-cms',
                    'categoryTag' => 'Digital Experience & Headless CMS',
                    'categoryFilter' => 'cms',
                    'badge' => 'API-First & Edge Ready',
                    'badgeColor' => 'bg-[#f43f5e]/15 text-[#f43f5e] border-[#f43f5e]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'Garibondhu360™',
                'subtitle' => 'Automotive Repair, Garage & Workshop Operating Platform',
                'content' => 'Leading workshop operating system with digital job cards, camera vehicle condition intake, barcode spare parts stock, and technician commission tracking.',
                'sort_order' => 6,
                'is_active' => true,
                'metadata' => [
                    'id' => 'garibondhu-erp',
                    'categoryTag' => 'Automotive & Workshop ERP',
                    'categoryFilter' => 'hrms',
                    'badge' => 'Active Live SaaS',
                    'badgeColor' => 'bg-[#10b981]/15 text-[#10b981] border-[#10b981]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'MediCore Health™',
                'subtitle' => 'Hospital, Clinic & Patient Practice Management System',
                'content' => 'Secure clinical management ecosystem covering patient electronic health records (EHR), multi-doctor scheduling, diagnostic laboratory reporting, and pharmacy billing.',
                'sort_order' => 7,
                'is_active' => true,
                'metadata' => [
                    'id' => 'medicore-health',
                    'categoryTag' => 'Healthcare & Clinical ERP',
                    'categoryFilter' => 'cms',
                    'badge' => 'Clinic & Hospital Ready',
                    'badgeColor' => 'bg-[#06b6d4]/15 text-[#06b6d4] border-[#06b6d4]/30',
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
                ]
            ],
            [
                'page' => 'home',
                'section' => 'enterprise_software',
                'title' => 'BillVibe POS™',
                'subtitle' => 'High-Speed Cloud Point of Sale & Centralized Inventory',
                'content' => 'Lightning-fast 0.2-second barcode checkout system with offline transaction resilience, multi-branch centralized warehouse sync, and customer loyalty rewards.',
                'sort_order' => 8,
                'is_active' => true,
                'metadata' => [
                    'id' => 'billvibe-pos',
                    'categoryTag' => 'Retail & Multi-Branch POS',
                    'categoryFilter' => 'cms',
                    'badge' => 'Multi-Branch & Retail Ready',
                    'badgeColor' => 'bg-[#ec4899]/15 text-[#ec4899] border-[#ec4899]/30',
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
                ]
            ],

            // =========================================================================
            // GLOBAL REACH / COUNTRIES WORKED
            // =========================================================================
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'United States',
                'content' => 'US',
                'sort_order' => 1,
                'is_active' => true,
                'metadata' => ['id' => 'us', 'name' => 'United States', 'flagUrl' => '/flags/us.svg', 'code' => 'US']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'United Kingdom',
                'content' => 'GB',
                'sort_order' => 2,
                'is_active' => true,
                'metadata' => ['id' => 'uk', 'name' => 'United Kingdom', 'flagUrl' => '/flags/gb.svg', 'code' => 'GB']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Canada',
                'content' => 'CA',
                'sort_order' => 3,
                'is_active' => true,
                'metadata' => ['id' => 'ca', 'name' => 'Canada', 'flagUrl' => '/flags/ca.svg', 'code' => 'CA']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Australia',
                'content' => 'AU',
                'sort_order' => 4,
                'is_active' => true,
                'metadata' => ['id' => 'au', 'name' => 'Australia', 'flagUrl' => '/flags/au.svg', 'code' => 'AU']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Germany',
                'content' => 'DE',
                'sort_order' => 5,
                'is_active' => true,
                'metadata' => ['id' => 'de', 'name' => 'Germany', 'flagUrl' => '/flags/de.svg', 'code' => 'DE']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'United Arab Emirates',
                'content' => 'AE',
                'sort_order' => 6,
                'is_active' => true,
                'metadata' => ['id' => 'ae', 'name' => 'United Arab Emirates', 'flagUrl' => '/flags/ae.svg', 'code' => 'AE']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Saudi Arabia',
                'content' => 'SA',
                'sort_order' => 7,
                'is_active' => true,
                'metadata' => ['id' => 'sa', 'name' => 'Saudi Arabia', 'flagUrl' => '/flags/sa.svg', 'code' => 'SA']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Singapore',
                'content' => 'SG',
                'sort_order' => 8,
                'is_active' => true,
                'metadata' => ['id' => 'sg', 'name' => 'Singapore', 'flagUrl' => '/flags/sg.svg', 'code' => 'SG']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'India',
                'content' => 'IN',
                'sort_order' => 9,
                'is_active' => true,
                'metadata' => ['id' => 'in', 'name' => 'India', 'flagUrl' => '/flags/in.svg', 'code' => 'IN']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Pakistan',
                'content' => 'PK',
                'sort_order' => 10,
                'is_active' => true,
                'metadata' => ['id' => 'pk', 'name' => 'Pakistan', 'flagUrl' => '/flags/pk.svg', 'code' => 'PK']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Bangladesh',
                'content' => 'BD',
                'sort_order' => 11,
                'is_active' => true,
                'metadata' => ['id' => 'bd', 'name' => 'Bangladesh', 'flagUrl' => '/flags/bd.svg', 'code' => 'BD']
            ],
            [
                'page' => 'home',
                'section' => 'countries_worked',
                'title' => 'Malaysia',
                'content' => 'MY',
                'sort_order' => 12,
                'is_active' => true,
                'metadata' => ['id' => 'my', 'name' => 'Malaysia', 'flagUrl' => '/flags/my.svg', 'code' => 'MY']
            ],

            // Global Delivery Pillars
            [
                'page' => 'home',
                'section' => 'global_pillars',
                'title' => 'Client IP Ownership',
                'subtitle' => '100%',
                'content' => 'Full GitHub repository handover with zero vendor lock-in & strict mutual NDA.',
                'sort_order' => 1,
                'is_active' => true,
                'metadata' => ['stat' => '100%', 'color' => '#00d4aa', 'icon' => 'ShieldCheckIcon']
            ],
            [
                'page' => 'home',
                'section' => 'global_pillars',
                'title' => 'Multi-Timezone Sprints',
                'subtitle' => '24/7',
                'content' => 'Dedicated overlap across North America (EST/PST), UK, Middle East & Asia hours.',
                'sort_order' => 2,
                'is_active' => true,
                'metadata' => ['stat' => '24/7', 'color' => '#38bdf8', 'icon' => 'ClockIcon']
            ],
            [
                'page' => 'home',
                'section' => 'global_pillars',
                'title' => 'Cross-Border Invoicing',
                'subtitle' => 'Multi-Currency',
                'content' => 'Seamless invoicing in USD, GBP, EUR, AED, and BDT via Stripe & Wire Transfer.',
                'sort_order' => 3,
                'is_active' => true,
                'metadata' => ['stat' => 'Multi-Currency', 'color' => '#8b5cf6', 'icon' => 'ArrowsRightLeftIcon']
            ],
            [
                'page' => 'home',
                'section' => 'global_pillars',
                'title' => 'Enterprise Cloud SLA',
                'subtitle' => '99.98%',
                'content' => 'Low-latency global edge deployment backed by AWS, Vercel & Cloudflare.',
                'sort_order' => 4,
                'is_active' => true,
                'metadata' => ['stat' => '99.98%', 'color' => '#10b981', 'icon' => 'ServerIcon']
            ],

            // =========================================================================
            // ECOSYSTEM DIVISIONS (Circular Orbit Master Brand)
            // =========================================================================
            [
                'page' => 'home',
                'section' => 'ecosystem_divisions',
                'title' => 'NextDigi Solutions',
                'subtitle' => 'Technology & Software Development',
                'content' => 'Custom SaaS platforms, Next.js 16 web applications, cloud backends, and full-stack architectures.',
                'sort_order' => 1,
                'is_active' => true,
                'metadata' => [
                    'id' => 'solutions',
                    'shortName' => 'Solutions',
                    'badge' => 'Web & SaaS',
                    'color' => '#00d4aa',
                    'accentColor' => '#38bdf8',
                    'glowColor' => 'rgba(0, 212, 170, 0.5)',
                    'metric' => '18ms Edge Latency • 100% Client IP',
                    'href' => '/solutions',
                ]
            ],
            [
                'page' => 'home',
                'section' => 'ecosystem_divisions',
                'title' => 'NextDigi AI',
                'subtitle' => 'AI & Autonomous Automation',
                'content' => 'Autonomous agentic workflows, private RAG knowledge bases, WhatsApp bots, and CRM auto-dispatch.',
                'sort_order' => 2,
                'is_active' => true,
                'metadata' => [
                    'id' => 'ai',
                    'shortName' => 'NextDigi AI',
                    'badge' => 'AI & Agents',
                    'color' => '#8b5cf6',
                    'accentColor' => '#c084fc',
                    'glowColor' => 'rgba(139, 92, 246, 0.5)',
                    'metric' => 'Multi-Model LLM • WhatsApp API 24/7',
                    'href' => '/ai',
                ]
            ],
            [
                'page' => 'home',
                'section' => 'ecosystem_divisions',
                'title' => 'NextDigi Growth',
                'subtitle' => 'Digital Marketing & Growth',
                'content' => 'Server-side CAPI tracking, Meta & Google Performance Max ads, Technical SEO, and automated retargeting.',
                'sort_order' => 3,
                'is_active' => true,
                'metadata' => [
                    'id' => 'growth',
                    'shortName' => 'Growth',
                    'badge' => 'Growth & Ads',
                    'color' => '#10b981',
                    'accentColor' => '#34d399',
                    'glowColor' => 'rgba(16, 185, 129, 0.5)',
                    'metric' => '4.6x Average ROAS • 99.4% Match Rate',
                    'href' => '/growth',
                ]
            ],
            [
                'page' => 'home',
                'section' => 'ecosystem_divisions',
                'title' => 'NextDigi Labs',
                'subtitle' => 'SaaS & Proprietary Products',
                'content' => 'Flagship software products including NextDigi Commerce and Garibondhu360 automotive platform.',
                'sort_order' => 4,
                'is_active' => true,
                'metadata' => [
                    'id' => 'labs',
                    'shortName' => 'NextDigi Labs',
                    'badge' => 'SaaS Products',
                    'color' => '#f59e0b',
                    'accentColor' => '#fbbf24',
                    'glowColor' => 'rgba(245, 158, 11, 0.5)',
                    'metric' => 'Commerce & Garibondhu360 Live',
                    'href' => '/labs',
                ]
            ],
            [
                'page' => 'home',
                'section' => 'ecosystem_divisions',
                'title' => 'NextDigi Store',
                'subtitle' => 'Digital Assets & Templates',
                'content' => 'Curated marketplace of production source codes, mobile app templates, ERP scripts, and business tools.',
                'sort_order' => 5,
                'is_active' => true,
                'metadata' => [
                    'id' => 'store',
                    'shortName' => 'NextDigi Store',
                    'badge' => 'Digital Assets',
                    'color' => '#f43f5e',
                    'accentColor' => '#fb7185',
                    'glowColor' => 'rgba(244, 63, 94, 0.5)',
                    'metric' => 'Instant Download • Verified Clean Code',
                    'href' => '/store',
                ]
            ],
            [
                'page' => 'home',
                'section' => 'ecosystem_divisions',
                'title' => 'NextDigi Cloud & Security',
                'subtitle' => 'Enterprise Infrastructure & IP',
                'content' => 'PostgreSQL Row-Level Security (RLS), multi-region Edge CDN delivery, and full client IP ownership protection.',
                'sort_order' => 6,
                'is_active' => true,
                'metadata' => [
                    'id' => 'cloud',
                    'shortName' => 'Cloud & IP',
                    'badge' => 'Edge & Security',
                    'color' => '#0284c7',
                    'accentColor' => '#6366f1',
                    'glowColor' => 'rgba(2, 132, 199, 0.5)',
                    'metric' => '100% Code Ownership • 99.98% SLA',
                    'href' => '/solutions',
                ]
            ],

            // =========================================================================
            // METHODOLOGY (BUILD • LAUNCH • AUTOMATE • GROW)
            // =========================================================================
            [
                'page' => 'home',
                'section' => 'methodology',
                'title' => 'BUILD',
                'subtitle' => 'Plan → Design → Develop',
                'content' => 'Requirements scoping, database modeling, and agile software development with modern TypeScript frameworks.',
                'sort_order' => 1,
                'is_active' => true,
                'metadata' => ['step' => '01']
            ],
            [
                'page' => 'home',
                'section' => 'methodology',
                'title' => 'LAUNCH',
                'subtitle' => 'Test → Deploy → Integrate',
                'content' => 'Comprehensive testing, automated CI/CD deployment pipelines, and zero-downtime production cutover.',
                'sort_order' => 2,
                'is_active' => true,
                'metadata' => ['step' => '02']
            ],
            [
                'page' => 'home',
                'section' => 'methodology',
                'title' => 'AUTOMATE',
                'subtitle' => 'AI → Workflow → Operations',
                'content' => 'Deploying autonomous AI agents, API webhooks, and event pipelines to eliminate manual bottlenecks.',
                'sort_order' => 3,
                'is_active' => true,
                'metadata' => ['step' => '03']
            ],
            [
                'page' => 'home',
                'section' => 'methodology',
                'title' => 'GROW',
                'subtitle' => 'Marketing → Analytics → Optimization',
                'content' => 'Data-driven advertising, conversion rate optimization, technical SEO, and scaling customer acquisition.',
                'sort_order' => 4,
                'is_active' => true,
                'metadata' => ['step' => '04']
            ],

            // =========================================================================
            // TRUST PILLARS (Why Businesses Choose NextDigi)
            // =========================================================================
            [
                'page' => 'home',
                'section' => 'why_choose_us',
                'title' => 'End-to-End Technology',
                'content' => 'From custom web and mobile platforms to cloud APIs, we deliver complete turn-key solutions under one roof.',
                'sort_order' => 1,
                'is_active' => true,
                'metadata' => ['icon' => 'CommandLineIcon']
            ],
            [
                'page' => 'home',
                'section' => 'why_choose_us',
                'title' => 'Custom Solutions',
                'content' => 'Every application is tailored to your business model with complete 100% intellectual property ownership transfer.',
                'sort_order' => 2,
                'is_active' => true,
                'metadata' => ['icon' => 'ShieldCheckIcon']
            ],
            [
                'page' => 'home',
                'section' => 'why_choose_us',
                'title' => 'AI & Automation',
                'content' => 'Deterministic AI agents and connected webhook pipelines that streamline repetitive operations and save overhead.',
                'sort_order' => 3,
                'is_active' => true,
                'metadata' => ['icon' => 'CpuChipIcon']
            ],
            [
                'page' => 'home',
                'section' => 'why_choose_us',
                'title' => 'SaaS Development',
                'content' => 'Multi-tenant database design, automated subscription recurring billing, and scalable edge deployment architectures.',
                'sort_order' => 4,
                'is_active' => true,
                'metadata' => ['icon' => 'ServerIcon']
            ],
            [
                'page' => 'home',
                'section' => 'why_choose_us',
                'title' => 'Enterprise SLA',
                'content' => 'Low-latency global edge deployment backed by AWS, Vercel & Cloudflare with continuous monitoring and zero downtime.',
                'sort_order' => 5,
                'is_active' => true,
                'metadata' => ['icon' => 'BoltIcon']
            ],
            [
                'page' => 'home',
                'section' => 'why_choose_us',
                'title' => 'Transparent Handover',
                'content' => 'Full GitHub repository handover, documentation, clean modular codebases, and zero vendor lock-in.',
                'sort_order' => 6,
                'is_active' => true,
                'metadata' => ['icon' => 'CodeBracketIcon']
            ],
        ];

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                [
                    'page' => $content['page'],
                    'section' => $content['section'],
                    'title' => $content['title'],
                ],
                $content
            );
        }
    }
}