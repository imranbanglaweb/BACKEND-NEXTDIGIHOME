<?php

namespace Database\Seeders;

use App\Models\AiChatbotSetting;
use App\Models\AiKnowledgeItem;
use Illuminate\Database\Seeder;

class AiChatbotKnowledgeSeeder extends Seeder
{
    /**
     * Seed initial settings & knowledge base.
     */
    public function run(): void
    {
        // 1. Ensure Settings exist
        AiChatbotSetting::instance();

        // 2. Default Knowledge Base Items
        $items = [
            // Enterprise Software 1: ParkPulse 360
            [
                'title' => 'ParkPulse 360™ - Automated Smart Parking & ANPR Barrier Management',
                'category' => 'software_catalog',
                'keywords' => 'parkpulse, parking, anpr, car parking, barrier, license plate recognition, smart parking, gari parking, parking erp, barrier gate',
                'content_en' => "### ParkPulse 360™ - Next-Gen Automated Parking Management\n\n**ParkPulse 360™** is an enterprise-grade Smart Parking Management ERP integrated with sub-second AI Automatic Number Plate Recognition (ANPR), automated boom barriers, and cashless mobile checkout.\n\n**Key Highlights:**\n- Sub-second License Plate Recognition (ANPR cameras with 99.4% accuracy).\n- Seamless hardware integration with ZKTeco, Dahua, Hikvision, and RFID barrier gates.\n- Instant ticketless entry and exit with automated toll calculation.\n- Cashless payments: bKash, Nagad, POS credit card swipe, and subscription passes.\n- Live parking slot occupancy sensor dashboard & automated multi-floor guidance.\n- Cloud and On-Premise deployments available.",
                'content_bn' => "### ParkPulse 360™ - স্মার্ট এএনপিআর পার্কিং ও ব্যারিয়ার ম্যানেজমেন্ট\n\n**ParkPulse 360™** হলো অত্যাধুনিক অটোমেটিক নাম্বার প্লেট রিকগনিশন (ANPR) সমৃদ্ধ স্মার্ট পার্কিং ম্যানেজমেন্ট সফটওয়্যার।\n\n**মূল সুবিধাসমূহ:**\n- ক্যামেরার মাধ্যমে স্বয়ংক্রিয় গাড়ি ও বাইকের নাম্বার প্লেট স্ক্যানিং (০.৩ সেকেন্ডের মধ্যে)।\n- অটোমেটিক বুম ব্যারিয়ার ও গেট কন্ট্রোলার ইন্টিগ্রেশন (ZKTeco, Hikvision ইত্যাদি)।\n- ডিজিটাল টিকিট ও বিকাশ/নগদ/কার্ডের মাধ্যমে ক্যাশলেস পেমেন্ট কালেকশন।\n- রিয়েল-টাইম ফ্রি স্লট কাউন্টিং এবং মাল্টি-লেভেল পার্কিং ডিসপ্লে।\n- বাণিজ্যিক ভবন, শপিং মল, বিমানবন্দর ও হাসপাতালের জন্য সম্পূর্ণ রেডি。",
                'content_banglish' => "### ParkPulse 360™ - Smart ANPR Parking & Barrier ERP\n\n**ParkPulse 360™** holo automated smart parking management system ja camera diye automatic gari'r number plate scan kore barrier open kore dei ebong cashless billing kore.\n\n**Highlights:**\n- 0.3s fast ANPR License Plate scan.\n- Automatic boom barrier gate control.\n- Ticketless entry/exit with bKash, Nagad, Card payment.\n- Real-time slot occupancy dashboard.\n- Shopping mall, corporate tower, airport-er jonno best.",
                'suggested_questions' => [
                    'ParkPulse 360 live demo kivabe dekhbo?',
                    'Barrier hardware ki apnara provide koren?',
                    'ParkPulse er pricing koto?'
                ],
                'actions' => [
                    ['label' => 'Live Demo & Quotation', 'url' => '/contact?product=ParkPulse%20360&service=Custom%20Software', 'type' => 'demo', 'isExternal' => false],
                    ['label' => 'WhatsApp Specialist', 'url' => 'https://wa.me/8801918329829?text=Interested%20in%20ParkPulse%20360%20Parking%20ERP', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'matched_items' => [
                    [
                        'id' => 'parking-software',
                        'name' => 'ParkPulse 360™',
                        'category' => 'Smart Mobility & ANPR',
                        'tagline' => 'Automated Smart Parking & ANPR Barrier Management with sub-second plate scan and cashless checkout.',
                        'badge' => 'Hardware & IoT Ready',
                        'price' => 'Custom Enterprise / SaaS',
                        'url' => '/contact?product=ParkPulse%20360&service=Custom%20Software',
                        'color' => '#00d4aa'
                    ]
                ],
                'priority' => 10,
                'is_active' => true
            ],

            // Enterprise Software 2: NetShield LAN
            [
                'title' => 'NetShield LAN™ - Enterprise LAN, ISP & Bandwidth Controller',
                'category' => 'software_catalog',
                'keywords' => 'netshield, mikrotik, isp billing, hotspot, captive portal, bandwidth, radius, voucher, wifi billing, internet billing',
                'content_en' => "### NetShield LAN™ - ISP & Corporate Network Automation\n\n**NetShield LAN™** is an intelligent Bandwidth, Hotspot Voucher, and ISP Billing controller built for corporate campuses, hotels, hospitals, and internet service providers.\n\n**Key Highlights:**\n- MikroTik RouterOS API & Cisco hardware deep integration.\n- Captive portal with instant SMS OTP guest login & customized branding.\n- Automated Wi-Fi voucher generator (Time/Data/Speed quota packages).\n- Automated ISP billing with bKash/Nagad auto-recharge and instant line unlock.\n- Anti-Mac cloning, rogue DHCP protection & cyber audit logs.",
                'content_bn' => "### NetShield LAN™ - আইএসপি ও কর্পোরেট হটস্পট ভাউচার কন্ট্রোলার\n\n**NetShield LAN™** হলো মাইক্রোটিক ও সিসকো রাউটার নিয়ন্ত্রিত শক্তিশালী আইএসপি বিলিং এবং ওয়াই-ফাই হটস্পট ভাউচার ম্যানেজমেন্ট সিস্টেম।\n\n**মূল সুবিধাসমূহ:**\n- মাইক্রোটিক রাউটারওএস (Mikrotik RouterOS) সম্পূর্ণ অটোমেশন।\n- এসএমএস ওটিপি ভেরিফিকেশন সহ ব্র্যান্ডেড ক্যাপটিভ পোর্টাল লগইন।\n- হোটেল, ক্যাফে ও ক্যাম্পাসের জন্য অটোমেটিক প্রিন্টেবল ওয়াই-ফাই ভাউচার।\n- বিকাশ ও নগদ পেমেন্ট গেটওয়ের মাধ্যমে কাস্টমার অটো রিচার্জ ও লাইন রিনিউ।",
                'content_banglish' => "### NetShield LAN™ - ISP Billing & Hotspot Voucher Controller\n\n**NetShield LAN™** diye Mikrotik router control, ISP client billing ebong WiFi Hotspot voucher generate kora jai automatically.\n\n**Highlights:**\n- Mikrotik API auto sync.\n- SMS OTP Hotspot Captive Portal.\n- Automated bKash/Nagad payment auto-reconnect.\n- Hotel, resort, campus & ISP company-r jonno ready.",
                'suggested_questions' => [
                    'NetShield LAN Mikrotik support kore?',
                    'Hotspot SMS OTP kivabe kaj kore?',
                    'ISP billing system demo'
                ],
                'actions' => [
                    ['label' => 'Request NetShield Demo', 'url' => '/contact?product=NetShield%20LAN&service=Custom%20Software', 'type' => 'demo', 'isExternal' => false],
                    ['label' => 'WhatsApp Tech Team', 'url' => 'https://wa.me/8801918329829?text=Interested%20in%20NetShield%20LAN%20Controller', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'matched_items' => [
                    [
                        'id' => 'lan-management',
                        'name' => 'NetShield LAN™',
                        'category' => 'Network Ops & Cybersecurity',
                        'tagline' => 'Enterprise LAN, ISP & Bandwidth Controller with Mikrotik & Cisco auto-provisioning & SMS OTP.',
                        'badge' => 'ISP & Enterprise Ready',
                        'price' => 'Custom Enterprise',
                        'url' => '/contact?product=NetShield%20LAN&service=Custom%20Software',
                        'color' => '#38bdf8'
                    ]
                ],
                'priority' => 9,
                'is_active' => true
            ],

            // Enterprise Software 3: Garibondhu360
            [
                'title' => 'Garibondhu360™ - Automobile Workshop & Garage Management ERP',
                'category' => 'software_catalog',
                'keywords' => 'garibondhu, garage erp, workshop, car service, auto repair, spare parts, mechanic, job card, gari service',
                'content_en' => "### Garibondhu360™ - Cloud Garage & Workshop Management\n\n**Garibondhu360™** is Bangladesh's leading automobile garage & repair workshop management SaaS platform.\n\n**Key Highlights:**\n- Digital Job Card creation with customer SMS notification.\n- Spare-parts inventory with barcode scanning & low-stock alerts.\n- Technician productivity and commission tracking.\n- Vehicle service history timeline & automated maintenance reminders.\n- Full accounting with invoice printing & profit/loss statements.\n- Live URL: https://garibondhu360.nextdigihome.com/",
                'content_bn' => "### Garibondhu360™ - অটোমোবাইল গ্যারেজ ও ওয়ার্কশপ ম্যানেজমেন্ট\n\n**Garibondhu360™** হলো আধুনিক অটো রিপেয়ার ও সার্ভিসিং ওয়ার্কশপের জন্য পূর্ণাঙ্গ ইআরপি সফটওয়্যার।\n\n**মূল সুবিধাসমূহ:**\n- ডিজিটাল জব কার্ড তৈরি ও কাস্টমারকে এসএমএস নোটিফিকেশন।\n- পার্টস ইনভেন্টরি, বারকোড এবং লো-স্টক অ্যালার্ট।\n- মেকানিক কমিশন ও টেকনিশিয়ান পারফরম্যান্স হিসাব।\n- গাড়ির পূর্ণাঙ্গ সার্ভিস হিস্ট্রি ও পরবর্তী সার্ভিসের অটো রিমাইন্ডার।",
                'content_banglish' => "### Garibondhu360™ - Auto Repair Workshop ERP\n\n**Garibondhu360™** holo car & bike garage management software ja diye job card, spare parts stock, mechanic commission ebong accounting kora jai.\n\n**Live Website:** https://garibondhu360.nextdigihome.com/",
                'suggested_questions' => [
                    'Garibondhu360 er monthly charge koto?',
                    'Job card kivabe print hoy?',
                    'Garage er accounting ki included?'
                ],
                'actions' => [
                    ['label' => 'Visit Garibondhu360.com', 'url' => 'https://garibondhu360.nextdigihome.com/', 'type' => 'link', 'isExternal' => true],
                    ['label' => 'Book Workshop Demo', 'url' => 'https://wa.me/8801918329829?text=Garibondhu360%20Workshop%20Software%20Demo', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'matched_items' => [
                    [
                        'id' => 'garibondhu360',
                        'name' => 'Garibondhu360™',
                        'category' => 'Automotive & Workshop ERP',
                        'tagline' => 'Complete Automobile Workshop & Garage Management with spare-parts inventory and job cards.',
                        'badge' => 'Live SaaS Product',
                        'price' => 'SaaS Subscription / One-time',
                        'url' => 'https://garibondhu360.nextdigihome.com/',
                        'color' => '#10b981'
                    ]
                ],
                'priority' => 9,
                'is_active' => true
            ],

            // Enterprise Software 4: MediCore Health
            [
                'title' => 'MediCore Health™ - Hospital, Clinic & Diagnostic Practice ERP',
                'category' => 'software_catalog',
                'keywords' => 'medicore, hospital, clinic, diagnostic, emr, doctor appointment, patient erp, pharmacy pos, lab report',
                'content_en' => "### MediCore Health™ - Clinical & Hospital ERP\n\n**MediCore Health™** is a modular Healthcare ERP built for specialized clinics, diagnostic labs, and multi-bed hospitals.\n\n**Key Highlights:**\n- Electronic Medical Records (EMR) & Digital Prescription Pad.\n- Doctor serial scheduling with SMS alerts.\n- Diagnostic Lab test token, result entry & auto-generated PDF report.\n- IPD (Inpatient bed admission & discharge summary) + OPD billing.\n- Integrated Pharmacy POS with batch expiry tracking.",
                'content_bn' => "### MediCore Health™ - হাসপাতাল, ক্লিনিক ও ডায়াগনস্টিক ইআরপি\n\n**MediCore Health™** আধুনিক ক্লিনিক, হাসপাতাল ও টেস্ট ল্যাবের জন্য পূর্ণাঙ্গ ম্যানেজমেন্ট সলিউশন।\n\n**মূল সুবিধাসমূহ:**\n- ডিজিটাল প্রেসক্রিপশন ও রোগীর প্রেসক্রিপশন হিস্ট্রি (EMR)।\n- ডাক্তার চেম্বার ও সিরিয়াল শিডিউলিং।\n- ডায়াগনস্টিক ল্যাব টেস্ট এন্ট্রি ও বারকোড সহ স্বয়ংক্রিয় রিপোর্ট প্রিন্টিং।\n- ফার্মেসি সেলস এবং ইনডোর পেশেন্ট অ্যাডমিশন হিসাব।",
                'content_banglish' => "### MediCore Health™ - Clinic & Hospital Software\n\n**MediCore Health™** holo hospital, diagnostic centre ebong doctor clinic-er complete ERP software.\n\n**Highlights:**\n- Doctor appointment & Serial token.\n- Digital Prescription & Medical Records (EMR).\n- Diagnostic test report with barcode.\n- Pharmacy billing with expiry tracker.",
                'suggested_questions' => [
                    'Diagnostic lab reporting feature ache?',
                    'Doctor appointment booking kivabe kaj kore?',
                    'Hospital software demo dekhte chai'
                ],
                'actions' => [
                    ['label' => 'Hospital ERP Demo', 'url' => '/contact?product=MediCore%20Health&service=Custom%20Software', 'type' => 'demo', 'isExternal' => false],
                    ['label' => 'WhatsApp Consultation', 'url' => 'https://wa.me/8801918329829?text=Interested%20in%20MediCore%20Hospital%20ERP', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'matched_items' => [
                    [
                        'id' => 'medicore-health',
                        'name' => 'MediCore Health™',
                        'category' => 'Healthcare & Clinical ERP',
                        'tagline' => 'Hospital, Clinic & Patient Practice Management with EMR, doctor scheduling & pharmacy POS.',
                        'badge' => 'Clinic & Hospital Ready',
                        'price' => 'Custom Clinical ERP',
                        'url' => '/contact?product=MediCore%20Health&service=Custom%20Software',
                        'color' => '#06b6d4'
                    ]
                ],
                'priority' => 8,
                'is_active' => true
            ],

            // Enterprise Software 5: BillVibe POS
            [
                'title' => 'BillVibe POS™ - Sub-Second Cloud & Retail Multi-Branch POS',
                'category' => 'software_catalog',
                'keywords' => 'billvibe, pos, retail, super shop, billing software, barcode checkout, multi branch, dokaan hisab, inventory pos',
                'content_en' => "### BillVibe POS™ - Ultra-Fast Multi-Branch Retail POS\n\n**BillVibe POS™** delivers lightning-fast 0.2-second barcode checkout designed for supermarkets, retail clothing brands, electronics outlets, and chain stores.\n\n**Key Highlights:**\n- Sub-second barcode scanning & receipt printing (58mm/80mm thermal).\n- Multi-branch centralized stock sync & warehouse transfer.\n- Offline checkout mode (never loses sales during internet cutouts).\n- Customer loyalty points, automated discount coupons & bKash QR.\n- Accurate profit margin, VAT & daily sales closing reports.",
                'content_bn' => "### BillVibe POS™ - সুপারফাস্ট রিটেইল ও মাল্টি-ব্রাঞ্চ পিওএস\n\n**BillVibe POS™** হলো সুপারশপ, পোশাকের আউটলেট ও চেইন শপের জন্য ০.২ সেকেন্ড গতির আল্ট্রা-ফাস্ট বারকোড ক্যাশ কাউন্টার সফটওয়্যার।\n\n**মূল সুবিধাসমূহ:**\n- যেকোনো বারকোড স্ক্যানার ও থার্মাল প্রিন্টারের সাথে শতভাগ সামঞ্জস্যপূর্ণ।\n- ইন্টারনেট চলে গেলেও অফলাইন মোডে নিরবচ্ছিন্ন ক্যাশমেমো তৈরি।\n- একাধিক শাখা বা ব্রাঞ্চের ইনভেন্টরি অটোমেশন।\n- কাস্টমার লয়ালটি পয়েন্ট ও দৈনিক প্রফিট/লস রিপোর্ট।",
                'content_banglish' => "### BillVibe POS™ - Fast Retail POS & Multi-Branch\n\n**BillVibe POS™** holo ultra-fast super shop & retail store billing system. Barcode scan korar sathe sathe 0.2s-e receipt print hoy.\n\n**Highlights:**\n- Offline billing mode (Net charao cholbe).\n- Multi-branch stock transfer.\n- Thermal printer & Barcode ready.\n- Daily profit & VAT report.",
                'suggested_questions' => [
                    'BillVibe POS offline-e kaj kore?',
                    'Multi branch inventory sync hoy?',
                    'Retail POS demo dekhte chai'
                ],
                'actions' => [
                    ['label' => 'Get POS Demo', 'url' => '/contact?product=BillVibe%20POS&service=Custom%20Software', 'type' => 'demo', 'isExternal' => false],
                    ['label' => 'WhatsApp Sales', 'url' => 'https://wa.me/8801918329829?text=Interested%20in%20BillVibe%20POS', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'matched_items' => [
                    [
                        'id' => 'billvibe-pos',
                        'name' => 'BillVibe POS™',
                        'category' => 'Retail & Multi-Branch POS',
                        'tagline' => 'Lightning-fast 0.2s barcode checkout with multi-branch real-time inventory and offline sync.',
                        'badge' => 'Multi-Branch & Retail Ready',
                        'price' => 'SaaS / Standalone',
                        'url' => '/contact?product=BillVibe%20POS&service=Custom%20Software',
                        'color' => '#ec4899'
                    ]
                ],
                'priority' => 8,
                'is_active' => true
            ],

            // Service: Web Development
            [
                'title' => 'Custom Web Development & Corporate Portals',
                'category' => 'solutions',
                'keywords' => 'web development, website, website banano, laravel, nextjs, react, landing page, custom web, web portal, corporate website',
                'content_en' => "### NextDigi Solutions - Custom Web Development\n\nWe build high-performance web applications and corporate portals engineered for speed, high SEO scores (95+ Google PageSpeed), and rock-solid security.\n\n**Technologies:** Next.js 14/15, React, Node.js, Laravel 11/12, Tailwind CSS, PostgreSQL/MySQL.\n\n**What You Get:**\n- Full responsive design (mobile, tablet, desktop).\n- SEO-first semantic architecture & meta tag setup.\n- Lightning edge caching with CDN.\n- Intuitive custom admin dashboard for easy content updates.\n- Starting from ৳15,000 for standard corporate sites to ৳45,000+ for custom web portals.",
                'content_bn' => "### কাস্টম ওয়েবসাইট ও ওয়েব পোর্টাল ডেভেলপমেন্ট\n\nআমরা অত্যাধুনিক প্রযুক্তিতে (Next.js, React, Laravel) দ্রুতগতির, এসইও-বান্ধব এবং দৃষ্টিনন্দন ওয়েবসাইট তৈরি করি।\n\n**মূল সুবিধাসমূহ:**\n- ৯৫+ গুগল পেজস্পিড স্কোর ও মোবাইল ফ্রেন্ডলি ডিজাইন।\n- সহজে কনটেন্ট পরিবর্তনের জন্য অ্যাডমিন প্যানেল।\n- এসইও ও ফেসবুক পিক্সেল সম্পূর্ণ সেটআপ।\n- কর্পোরেট ওয়েবসাইট শুরু ১৫,০০০ টাকা থেকে।",
                'content_banglish' => "### Custom Website & Corporate Portal Development\n\nAmra modern technology (Next.js, React, Laravel) diye fast & SEO-friendly website build kori.\n\n**Packages:**\n- Starter Corporate Website: ৳15,000 - ৳25,000\n- Advanced Dynamic Web Portal: ৳35,000 - ৳65,000+\n- 95+ PageSpeed & Mobile Friendly Guarantee.",
                'suggested_questions' => [
                    'Website banate koto din somoy lage?',
                    'Domain hosting ki apnara provide koren?',
                    'Website er portfolio dekhte chai'
                ],
                'actions' => [
                    ['label' => 'Explore Web Solutions', 'url' => '/solutions/web-development', 'type' => 'link', 'isExternal' => false],
                    ['label' => 'WhatsApp Project Discussion', 'url' => 'https://wa.me/8801918329829?text=I%20want%20to%20build%20a%20website', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'priority' => 8,
                'is_active' => true
            ],

            // Service: E-Commerce Development
            [
                'title' => 'E-Commerce & Multivendor Online Store Platforms',
                'category' => 'solutions',
                'keywords' => 'ecommerce, online shop, store, bkash payment, nagad, courier api, steadfast, pathao, daraz, multivendor, online dokaan',
                'content_en' => "### NextDigi Solutions - E-Commerce Platforms\n\nWe engineer conversion-optimized online stores that scale seamlessly from 100 to 500,000+ orders.\n\n**Core Integrations:**\n- Automated bKash, Nagad, Rocket, Upay & Credit Card Payment Gateways (SSLCommerz, Shurjopay, AamarPay).\n- Courier automated order booking: Steadfast, Pathao, RedX API with real-time tracking.\n- One-page high-converting checkout (up to 3x higher conversion rate).\n- Abandoned cart recovery with automated WhatsApp/SMS alerts.\n- Inventory sync & invoice printing.\n- Pricing: Starter stores from ৳25,000; Custom brand stores ৳45,000 - ৳85,000+.",
                'content_bn' => "### ই-কমার্স ও মাল্টিভেন্ডর অনলাইন শপ ডেভেলপমেন্ট\n\nআমরা উচ্চ কনভার্শন সম্পন্ন ই-কমার্স প্ল্যাটফর্ম তৈরি করি যা আপনার সেলস বহু গুণ বৃদ্ধি করতে সহায়ক।\n\n**ইন্টিগ্রেশনসমূহ:**\n- বিকাশ, নগদ, কার্ড পেমেন্ট গেটওয়ে।\n- রেডএক্স, পাঠাও ও স্টেডফাস্ট কুরিয়ার অটো বুকিং এপিআই।\n- ১-পেজ ফাস্ট চেকআউট (বিকাশ ফি ছাড়াই সহজে অর্ডার)।\n- ইনভয়েস জেনারেশন ও স্টক ম্যানেজমেন্ট।\n- প্রাইসিং: ২৫,০০০ থেকে ৬০,০০০+ টাকা।",
                'content_banglish' => "### E-commerce Website Development\n\nAmader e-commerce solution diye apnar online business grow korun seamlessly.\n\n**Features:**\n- bKash, Nagad, Card automated payment gateway.\n- Steadfast / Pathao courier auto parcel booking.\n- 1-page fast checkout.\n- Abandoned cart recovery.\n- Budget: ৳25,000 - ৳60,000+.",
                'suggested_questions' => [
                    'Ecommerce website banate koto khoroch?',
                    'Steadfast courier API ki connect thakbe?',
                    'bKash payment gateway kivabe integrate hoy?'
                ],
                'actions' => [
                    ['label' => 'View E-Commerce Demo', 'url' => '/solutions/ecommerce', 'type' => 'link', 'isExternal' => false],
                    ['label' => 'Discuss on WhatsApp', 'url' => 'https://wa.me/8801918329829?text=I%20need%20an%20ecommerce%20store', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'priority' => 9,
                'is_active' => true
            ],

            // Service: Mobile App Development
            [
                'title' => 'Mobile App Development (Flutter / iOS / Android)',
                'category' => 'solutions',
                'keywords' => 'mobile app, flutter, android, ios, app banano, playstore, app store, cross platform, react native',
                'content_en' => "### NextDigi Solutions - Mobile App Engineering\n\nWe build sleek, pixel-perfect, native-speed iOS and Android mobile apps using Google Flutter.\n\n**Features:**\n- Single codebase for both iOS (Apple App Store) and Android (Google Play Store).\n- Offline data caching, SQLite local storage & background synchronization.\n- Push notifications with Firebase Cloud Messaging (FCM).\n- Biometric Face ID / Fingerprint authentication.\n- In-app payments: bKash, Stripe, Google Pay, Apple Pay.\n- Pricing: ৳45,000 to ৳1,50,000+ depending on feature complexity.",
                'content_bn' => "### মোবাইল অ্যাপ ডেভেলপমেন্ট (অ্যান্ড্রয়েড ও আইওএস)\n\nআমরা গুগল ফ্লাটার (Flutter) প্রযুক্তি ব্যবহার করে একই সাথে অ্যান্ড্রয়েড ও আইওএস-এর জন্য হাই-পারফরম্যান্স মোবাইল অ্যাপ তৈরি করি।\n\n**সুবিধাসমূহ:**\n- গুগল প্লে স্টোর ও অ্যাপল অ্যাপ স্টোরে পাবলিশের পূর্ণ সহায়তা।\n- পুশ নোটিফিকেশন, অফলাইন ক্যাশিং ও ফাস্ট ইউজার ইন্টারফেস।\n- বিকাশ, নগদ ও কার্ড পেমেন্ট ইন-অ্যাপ চেকআউট।\n- বাজেট: ৪৫,০০০ টাকা থেকে ১,৫০,০০০+ টাকা।",
                'content_banglish' => "### Mobile App Development (Flutter)\n\nGoogle Flutter framework diye Android & iOS duto platform-er jonnoi super fast mobile app build kora hoy.\n\n**Budget:** ৳45,000 theke feature onujayi ৳1,50,000+.",
                'suggested_questions' => [
                    'Android o iPhone duto tei ki cholbe?',
                    'Play Store-e upload ki apnara kore deben?',
                    'Mobile app banate koto din lagbe?'
                ],
                'actions' => [
                    ['label' => 'Explore App Solutions', 'url' => '/solutions/mobile-app', 'type' => 'link', 'isExternal' => false],
                    ['label' => 'WhatsApp Mobile Team', 'url' => 'https://wa.me/8801918329829?text=Interested%20in%20Mobile%20App%20Development', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'priority' => 8,
                'is_active' => true
            ],

            // Service: AI Agents & Chatbots
            [
                'title' => 'AI Agents, Multilingual Chatbots & WhatsApp Automation',
                'category' => 'solutions',
                'keywords' => 'ai chatbot, ai agent, whatsapp bot, n8n, make automation, customer service bot, llm, gemini, gpt, bangla ai',
                'content_en' => "### NextDigi AI - Autonomous Agents & Multilingual Chatbots\n\nWe design and deploy custom conversational AI agents powered by Gemini 1.5, OpenAI GPT-4o, and dynamic RAG (Retrieval-Augmented Generation).\n\n**Capabilities:**\n- Fluent multilingual fluency: Bangla (বাংলা), English, and Banglish.\n- Official WhatsApp Cloud API Bots (automated customer support, catalog browsing, order taking).\n- Integration with CRM, Google Sheets, ERP & n8n / Make workflows.\n- 24/7 lead capture and qualification.\n- Pricing: ৳20,000 - ৳60,000+.",
                'content_bn' => "### এআই চ্যাটবট, হোয়াটসঅ্যাপ বট ও অটোমেশন\n\nআমরা বাংলা, ইংরেজি ও বাংলিশে সাবলীলভাবে কথা বলতে সক্ষম স্মার্ট এআই অ্যাসিস্ট্যান্ট তৈরি করি।\n\n**সুবিধাসমূহ:**\n- অফিসিয়াল হোয়াটসঅ্যাপ বিজনেস এপিআই ইন্টিগ্রেশন।\n- ২৪/৭ স্বয়ংক্রিয় কাস্টমার সাপোর্ট ও লিড ক্যাপচার।\n- আপনার বিজনেস ডেটাবেজ ও সিআরএম-এর সাথে স্বয়ংক্রিয় কানেকশন।\n- বাজেট: ২০,০০০ থেকে ৬০,০০০+ টাকা।",
                'content_banglish' => "### AI Chatbots & WhatsApp Automation\n\nAmader multilingual AI chatbot diye 24/7 customer support ebong lead capture kora jai easily.\n\n**Features:**\n- Bangla, English, Banglish 3 ta language-ei kotha bolte pare.\n- WhatsApp Business Bot integration.\n- CRM & Google Sheet sync.",
                'suggested_questions' => [
                    'WhatsApp-e ki AI bot integrate kora jabe?',
                    'Chatbot-er setup cost koto?',
                    'Bangla bhasha ki accurately bujhte pare?'
                ],
                'actions' => [
                    ['label' => 'Explore AI Bots', 'url' => '/ai/chatbots', 'type' => 'link', 'isExternal' => false],
                    ['label' => 'WhatsApp AI Specialist', 'url' => 'https://wa.me/8801918329829?text=Interested%20in%20AI%20Chatbots%20and%20Automation', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'priority' => 9,
                'is_active' => true
            ],

            // Company Contact & Office
            [
                'title' => 'NextDigiHome Contact, Office Location & Support Channels',
                'category' => 'company',
                'keywords' => 'contact, office, address, phone number, whatsapp, email, thikana, kothay, jogajog, helpline, support number',
                'content_en' => "### NextDigiHome - Office & Contact Channels\n\n- **Phone / WhatsApp:** +8801918329829\n- **Email:** info@nextdigihome.com\n- **Support Hours:** 24/7 Digital Support | Office Hours: 9:00 AM - 7:00 PM (Sat-Thu)\n- **Office Location:** Dhaka, Bangladesh\n- **Website:** https://nextdigihome.com",
                'content_bn' => "### নেক্সটডিজিহোম অফিস ও যোগাযোগের তথ্য\n\n- **ফোন / হোয়াটসঅ্যাপ:** +৮৮০১৯১৮৩২৯৮২৯ (+8801918329829)\n- **ইমেইল:** info@nextdigihome.com\n- **সাপোর্ট সময়:** ২৪/৭ ডিজিটাল সহায়তা | অফিস সময়: সকাল ৯:০০ - সন্ধ্যা ৭:০০ (শনি-বৃহ)\n- **অফিস ঠিকানা:** ঢাকা, বাংলাদেশ।",
                'content_banglish' => "### NextDigiHome Contact Details\n\n- **WhatsApp / Call:** +8801918329829\n- **Email:** info@nextdigihome.com\n- **Office:** Dhaka, Bangladesh\n- **Support:** 24/7 online WhatsApp support available.",
                'suggested_questions' => [
                    'Direct kotha bolte chai kar sathe bolbo?',
                    'Office er location kothay?',
                    'WhatsApp number ta din'
                ],
                'actions' => [
                    ['label' => 'Direct WhatsApp Chat', 'url' => 'https://wa.me/8801918329829?text=Hello%20NextDigiHome%20Team', 'type' => 'whatsapp', 'isExternal' => true],
                    ['label' => 'Visit Contact Page', 'url' => '/contact', 'type' => 'link', 'isExternal' => false]
                ],
                'priority' => 10,
                'is_active' => true
            ],

            // Pricing & Packages Overview
            [
                'title' => 'NextDigiHome Pricing, Packages & Quotation Guidelines',
                'category' => 'pricing',
                'keywords' => 'price, pricing, khoroch, dam, cost, package, budget, taka, quotation, quotation kivabe pabo, service charge',
                'content_en' => "### NextDigiHome Pricing & Packages (BDT ৳)\n\n- **Starter Corporate Website:** ৳15,000 - ৳25,000 (Fast Next.js/Laravel, 5 pages, mobile responsive, SEO basic).\n- **Advanced Dynamic Web Portal:** ৳35,000 - ৳65,000+ (Custom CMS, database integrations).\n- **High-Converting E-Commerce Store:** ৳25,000 - ৳60,000+ (bKash/Nagad gateway, Steadfast/Pathao courier auto booking).\n- **Cross-Platform Mobile App (Flutter):** ৳45,000 - ৳1,50,000+ (iOS & Android, push notifications).\n- **AI Chatbot & WhatsApp Automation:** ৳20,000 - ৳50,000+.\n- **Enterprise ERPs (ParkPulse 360, MediCore, BillVibe, NetShield):** Custom quotation based on scale.\n\nAll packages include source code ownership, free initial maintenance & warranty support!",
                'content_bn' => "### প্রাইসিং ও প্যাকেজ সমূহ (টাকা ৳)\n\n- **কর্পোরেট ওয়েবসাইট:** ১৫,০০০ - ২৫,০০০ টাকা।\n- **ডায়নামিক ওয়েব পোর্টাল:** ৩৫,০০০ - ৬৫,০০০+ টাকা।\n- **ই-কমার্স শপ (বিকাশ ও কুরিয়ার এপিআই সহ):** ২৫,০০০ - ৬০,০০০+ টাকা।\n- **মোবাইল অ্যাপ (অ্যান্ড্রয়েড + আইওএস):** ৪৫,০০০ - ১,৫০,০০০+ টাকা।\n- **এআই চ্যাটবট ও হোয়াটসঅ্যাপ বট:** ২০,০০০ - ৫০,০০০+ টাকা।\n- **এন্টারপ্রাইজ ইআরপি ও সফটওয়্যার:** কাস্টম কোটেশন।\n\nপ্রতিটি প্রজেক্টে সোর্স কোড সম্পূর্ণ হ্যান্ডওভার ও ওয়ারেন্টি সাপোর্ট অন্তর্ভুক্ত।",
                'content_banglish' => "### NextDigiHome Pricing Breakdown\n\n- Website: ৳15k - ৳25k+\n- E-Commerce: ৳25k - ৳60k+\n- Flutter Mobile App: ৳45k - ৳150k+\n- AI Bot / WhatsApp Automation: ৳20k - ৳50k+\n\nCustom quote pete amader WhatsApp korun: +8801918329829.",
                'suggested_questions' => [
                    'Payment method ki ki ache?',
                    'Advance payment koto dite hoy?',
                    'Warranty ba support koy mash pabo?'
                ],
                'actions' => [
                    ['label' => 'Get Instant Quotation', 'url' => '/contact', 'type' => 'link', 'isExternal' => false],
                    ['label' => 'WhatsApp Quotation', 'url' => 'https://wa.me/8801918329829?text=I%20need%20a%20price%20quotation%20for%20a%20project', 'type' => 'whatsapp', 'isExternal' => true]
                ],
                'priority' => 10,
                'is_active' => true
            ]
        ];

        foreach ($items as $data) {
            AiKnowledgeItem::updateOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
