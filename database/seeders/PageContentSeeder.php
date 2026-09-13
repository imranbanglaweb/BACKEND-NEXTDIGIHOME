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