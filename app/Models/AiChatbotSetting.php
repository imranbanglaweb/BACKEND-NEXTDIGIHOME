<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiChatbotSetting extends Model
{
    use HasFactory;

    protected $table = 'ai_chatbot_settings';

    protected $fillable = [
        'bot_enabled',
        'bot_name',
        'bot_tagline',
        'bot_avatar',
        'primary_provider',
        'fallback_provider',
        'gemini_api_key',
        'gemini_model',
        'openai_api_key',
        'openai_model',
        'temperature',
        'max_tokens',
        'system_prompt',
        'welcome_msg_en',
        'welcome_msg_bn',
        'welcome_msg_banglish',
        'suggested_chips',
        'whatsapp_number',
        'support_email',
        'support_phone',
        'auto_capture_leads',
        'sound_enabled_by_default',
        'lead_notification_email',
        'notification_recipient_email',
    ];

    protected $casts = [
        'bot_enabled' => 'boolean',
        'temperature' => 'float',
        'max_tokens' => 'integer',
        'suggested_chips' => 'array',
        'auto_capture_leads' => 'boolean',
        'sound_enabled_by_default' => 'boolean',
        'lead_notification_email' => 'boolean',
    ];

    /**
     * Singleton accessor for chatbot settings
     */
    public static function instance(): self
    {
        return static::firstOrCreate([], [
            'bot_enabled' => true,
            'bot_name' => 'NextDigi AI Concierge',
            'bot_tagline' => 'Enterprise Solution & AI Specialist',
            'primary_provider' => 'gemini',
            'fallback_provider' => 'local_rag',
            'gemini_model' => 'gemini-1.5-flash',
            'openai_model' => 'gpt-4o-mini',
            'temperature' => 0.70,
            'max_tokens' => 800,
            'system_prompt' => "You are NextDigiHome's AI Concierge & Solution Specialist.\nNextDigiHome is a technology ecosystem providing:\n- NextDigi Solutions (Custom Web Development, High-Conversion E-commerce with bKash/Nagad/Cards, Flutter/React Native Mobile Apps, Custom SaaS/ERP).\n- NextDigi AI (Autonomous AI Agents, Multilingual Chatbots in Bangla/English/Banglish, WhatsApp bots, n8n/Make Automations).\n- NextDigi Growth (SEO, Meta & Google Performance Ads, Digital Marketing).\n- NextDigi Labs Enterprise Software:\n  * ParkPulse 360™ (ANPR camera barrier parking management)\n  * MediCore Health™ (Hospital & clinic management ERP)\n  * BillVibe POS™ (Sub-second cloud retail POS & multi-branch inventory)\n  * NetShield LAN™ (ISP Mikrotik bandwidth & captive portal voucher controller)\n  * Garibondhu360™ (Automotive garage & workshop ERP)\n  * EduMatrix 360™ (School & campus management ERP)\n  * PulseHR Core™ (HR & Biometric attendance payroll ERP)\n- NextDigi Store (Source codes, Flutter templates, scripts).\nContact: Phone/WhatsApp: +8801918329829, Email: info@nextdigihome.com, Office: Dhaka, Bangladesh.\nPricing: Starter websites ৳15k-৳25k, E-commerce ৳25k-৳60k+, Mobile apps ৳45k-৳150k+, AI bots ৳20k-৳50k+.\nAnswer concisely, helpfully and warmly. If user writes in Bangla, reply in fluent Bangla. If user writes in Banglish, reply in friendly Banglish with clear bullet points. If in English, reply in professional English. If the user wants a quotation or service, politely offer to connect them on WhatsApp or note their contact number.",
            'welcome_msg_en' => "Hi! Welcome to **NextDigiHome**! 🚀\n\nI am your AI Solution Concierge. You can ask or search anything about our **Custom Software**, **Web & E-Commerce**, **Flutter Mobile Apps**, **AI Agents & Chatbots**, or **Pricing** in **English**, **বাংলা (Bangla)**, or **Banglish**!\n\nHow can I assist your business today?",
            'welcome_msg_bn' => "আসসালামু আলাইকুম! **NextDigiHome**-এ আপনাকে স্বাগতম। 🚀\n\nআমি আপনার এআই সলিউশন অ্যাসিস্ট্যান্ট। আমাদের **কাস্টম সফটওয়্যার**, **ওয়েবসাইট ও ই-কমার্স**, **মোবাইল অ্যাপ**, **এআই চ্যাটবট ও অটোমেশন** কিংবা **প্রাইসিং** সংক্রান্ত যেকোনো প্রশ্ন আপনি বাংলা, ইংরেজি বা বাংলিশে করতে পারেন!\n\nকীভাবে সাহায্য করতে পারি?",
            'welcome_msg_banglish' => "Hello! **NextDigiHome**-e apnake shagotom! 🚀\n\nAmra modern business-er jonno **Custom Website & E-commerce**, **Enterprise Software & ERP**, **Mobile Apps**, **AI Chatbot & Automation**, ebong **Digital Growth** service diye thaki.\n\nApni kon service ba software somporke jante chan? Nicher suggestion-e click korte paren ba type korun!",
            'suggested_chips' => [
                'ই-কমার্স ওয়েবসাইট খরচ কত?',
                'ParkPulse 360 Parking Demo',
                'Mobile app banate koto lagbe?',
                'AI Chatbot & Automation',
                'Contact & WhatsApp Support'
            ],
            'whatsapp_number' => '+8801918329829',
            'support_email' => 'info@nextdigihome.com',
            'support_phone' => '+8801918329829',
            'auto_capture_leads' => true,
            'sound_enabled_by_default' => false,
            'lead_notification_email' => false,
        ]);
    }
}
