<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $pages = [
            [
                'page' => 'about',
                'section' => 'main',
                'title' => 'About Next Digi Home',
                'content' => '<h2>Welcome to Next Digi Home</h2>
<p>Next Digi Home is your premier destination for digital products and marketplace solutions. We provide high-quality digital assets, tools, templates, and educational content to help creators, businesses, and entrepreneurs succeed in the digital world.</p>

<h3>Our Mission</h3>
<p>To democratize access to professional digital tools and resources, making it easier for everyone to create, build, and grow their digital presence.</p>

<h3>What We Offer</h3>
<ul>
<li><strong>Digital Products:</strong> High-quality templates, themes, and digital assets</li>
<li><strong>Educational Content:</strong> Comprehensive courses and learning materials</li>
<li><strong>Business Tools:</strong> Productivity software and business solutions</li>
<li><strong>Creative Assets:</strong> Graphics, photos, audio, and video content</li>
<li><strong>Developer Resources:</strong> Code, scripts, and development tools</li>
</ul>

<h3>Why Choose Us?</h3>
<ul>
<li>✓ Instant digital delivery</li>
<li>✓ Lifetime access to purchased products</li>
<li>✓ 30-day money-back guarantee</li>
<li>✓ Regular updates and support</li>
<li>✓ Secure payment processing</li>
</ul>',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'page' => 'terms',
                'section' => 'main',
                'title' => 'Terms of Service',
                'content' => '<h2>Terms of Service</h2>

<h3>1. Acceptance of Terms</h3>
<p>By accessing and using Next Digi Home, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h3>2. Use License</h3>
<p>Permission is granted to temporarily download one copy of the materials on Next Digi Home for personal, non-commercial transitory viewing only.</p>

<h3>3. Digital Products</h3>
<ul>
<li>All digital products are licensed, not sold</li>
<li>Licenses are non-transferable and non-exclusive</li>
<li>You may use purchased products for personal or commercial projects</li>
<li>Reselling or redistribution is strictly prohibited</li>
</ul>

<h3>4. Refund Policy</h3>
<p>We offer a 30-day money-back guarantee on all digital products. Refunds will be processed within 5-7 business days after approval.</p>

<h3>5. User Responsibilities</h3>
<ul>
<li>Provide accurate account information</li>
<li>Maintain the security of your account</li>
<li>Use the platform legally and ethically</li>
<li>Respect intellectual property rights</li>
</ul>',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'page' => 'privacy',
                'section' => 'main',
                'title' => 'Privacy Policy',
                'content' => '<h2>Privacy Policy</h2>

<h3>Information We Collect</h3>
<p>We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us for support.</p>

<h3>How We Use Your Information</h3>
<ul>
<li>To process and fulfill your orders</li>
<li>To communicate with you about your purchases</li>
<li>To provide customer support</li>
<li>To send marketing communications (with consent)</li>
<li>To improve our services and develop new features</li>
</ul>

<h3>Information Sharing</h3>
<p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

<h3>Data Security</h3>
<p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

<h3>Your Rights</h3>
<ul>
<li>Access to your personal information</li>
<li>Correction of inaccurate data</li>
<li>Deletion of your account and data</li>
<li>Opt-out of marketing communications</li>
<li>Data portability</li>
</ul>

<h3>Contact Us</h3>
<p>If you have any questions about this Privacy Policy, please contact us at privacy@nextdigihome.com</p>',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'page' => 'faq',
                'section' => 'main',
                'title' => 'Frequently Asked Questions',
                'content' => '<h2>Frequently Asked Questions</h2>

<h3>General Questions</h3>

<h4>What is Next Digi Home?</h4>
<p>Next Digi Home is a digital marketplace where you can buy and sell digital products, templates, courses, and creative assets.</p>

<h4>How do I create an account?</h4>
<p>Click the "Sign Up" button and fill in your details. You\'ll receive a confirmation email to activate your account.</p>

<h4>Is there a free trial?</h4>
<p>Some products offer free previews or demos. Check individual product pages for trial availability.</p>

<h3>Purchasing & Downloads</h3>

<h4>How do I purchase a product?</h4>
<p>Add items to your cart, proceed to checkout, and complete payment. You\'ll receive instant access to digital downloads.</p>

<h4>What payment methods do you accept?</h4>
<p>We accept credit cards, PayPal, Stripe, and bank transfers. All payments are processed securely.</p>

<h4>How long do I have access to purchased products?</h4>
<p>All purchases include lifetime access. You can download and use the products indefinitely.</p>

<h4>What file formats are included?</h4>
<p>This varies by product. Most include multiple formats (PSD, AI, PDF, etc.) and source files.</p>

<h3>Technical Support</h3>

<h4>How do I download my purchases?</h4>
<p>After purchase, go to your account dashboard and click "Downloads" for each purchased item.</p>

<h4>What if I have technical issues?</h4>
<p>Contact our support team through the help desk. We provide assistance within 24 hours.</p>

<h4>Can I get a refund?</h4>
<p>We offer a 30-day money-back guarantee. Contact support for refund requests.</p>

<h3>Account & Billing</h3>

<h4>How do I update my payment information?</h4>
<p>Go to Account Settings > Billing to update your payment methods.</p>

<h4>Can I cancel my subscription?</h4>
<p>Visit Account Settings > Subscriptions to manage or cancel your subscriptions.</p>

<h4>Do you offer discounts or coupons?</h4>
<p>Check our promotions page or subscribe to our newsletter for exclusive deals.</p>',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($pages as $page) {
            PageContent::create($page);
        }

        $this->command->info('ContentSeeder completed successfully!');
        $this->command->info('Created ' . count($pages) . ' additional content pages.');
    }
}
