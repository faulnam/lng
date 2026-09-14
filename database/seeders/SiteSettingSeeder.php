<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds for LNG Company Profile.
     */
    public function run(): void
    {
        $settings = [
            // Statistics (LNG Metrics)
            [
                'key' => 'total_projects',
                'value' => '5.2 MTPA',
                'group' => 'statistics',
                'label' => 'Total Annual LNG Supply Capacity',
                'type' => 'text',
            ],
            [
                'key' => 'years_experience',
                'value' => '18+',
                'group' => 'statistics',
                'label' => 'Years Operational Excellence & Safety',
                'type' => 'text',
            ],
            [
                'key' => 'media_awards_count',
                'value' => '12',
                'group' => 'statistics',
                'label' => 'Export Destinations & Terminals',
                'type' => 'text',
            ],
            [
                'key' => 'countries_served',
                'value' => '40+',
                'group' => 'statistics',
                'label' => 'Long-Term B2B Industrial Offtakers',
                'type' => 'text',
            ],
            [
                'key' => 'associate_partners',
                'value' => '8',
                'group' => 'statistics',
                'label' => 'Cryogenic Fleet & Regas Terminals',
                'type' => 'text',
            ],
            [
                'key' => 'total_clients',
                'value' => '40+',
                'group' => 'statistics',
                'label' => 'Corporate Offtakers & Utilities',
                'type' => 'text',
            ],
            [
                'key' => 'team_members_count',
                'value' => '150+',
                'group' => 'statistics',
                'label' => 'Specialized Engineers & Crew',
                'type' => 'text',
            ],
            [
                'key' => 'days_of_work',
                'value' => '15M+',
                'group' => 'statistics',
                'label' => 'Safe Working Hours (Zero LTI)',
                'type' => 'text',
            ],

            // Company Info & Branding
            [
                'key' => 'company_name',
                'value' => 'PT Nusantara LNG Energi',
                'group' => 'general',
                'label' => 'Company Name',
                'type' => 'text',
            ],
            [
                'key' => 'site_title',
                'value' => 'PT Nusantara LNG Energi — Integrated Liquefied Natural Gas Supply & Cryogenic Logistics',
                'group' => 'general',
                'label' => 'Site Title',
                'type' => 'text',
            ],
            [
                'key' => 'meta_description_default',
                'value' => 'PT Nusantara LNG Energi provides world-class liquefied natural gas (LNG) bulk supply, cryogenic ISO tank virtual pipelines, regasification terminals, and marine bunkering solutions across Asia Pacific.',
                'group' => 'general',
                'label' => 'Default Meta Description',
                'type' => 'textarea',
            ],

            // Contact Information
            [
                'key' => 'company_phone_1',
                'value' => '+62 21 5289 7700',
                'group' => 'contact',
                'label' => 'Headquarters Phone 1',
                'type' => 'text',
            ],
            [
                'key' => 'company_phone_2',
                'value' => '+62 21 5289 7701',
                'group' => 'contact',
                'label' => 'Commercial Desk Phone 2',
                'type' => 'text',
            ],
            [
                'key' => 'company_whatsapp',
                'value' => '+6281188997700',
                'group' => 'contact',
                'label' => 'Commercial WhatsApp Desk',
                'type' => 'text',
            ],
            [
                'key' => 'company_email_info',
                'value' => 'info@nusantara-lng.com',
                'group' => 'contact',
                'label' => 'General Inquiries Email',
                'type' => 'text',
            ],
            [
                'key' => 'company_email_hr',
                'value' => 'investor.relations@nusantara-lng.com',
                'group' => 'contact',
                'label' => 'Investor Relations Email',
                'type' => 'text',
            ],
            [
                'key' => 'company_email_marketing',
                'value' => 'commercial@nusantara-lng.com',
                'group' => 'contact',
                'label' => 'Commercial & Offtake Email',
                'type' => 'text',
            ],
            [
                'key' => 'company_address',
                'value' => "PT Nusantara LNG Energi\nMenara Gas & Energi Indonesia, 28th Floor\nKawasan SCBD Lot 11, Jl. Jend. Sudirman Kav. 52-53\nJakarta Selatan 12190, Indonesia",
                'group' => 'contact',
                'label' => 'Headquarters Address',
                'type' => 'textarea',
            ],
            [
                'key' => 'company_directions_url',
                'value' => 'https://maps.google.com/?q=SCBD+Jakarta+Indonesia',
                'group' => 'contact',
                'label' => 'Directions / Maps Link',
                'type' => 'text',
            ],
            [
                'key' => 'map_embed_url',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2736471676646!2d106.80800047583758!3d-6.227608160993081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f151525a74e3%3A0xb35a09ec66c72ec1!2sSCBD%20Jakarta!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid',
                'group' => 'contact',
                'label' => 'Google Map Embed URL',
                'type' => 'text',
            ],

            // Social Media & Credentials
            [
                'key' => 'social_instagram',
                'value' => 'https://www.linkedin.com/company/nusantara-lng-energi',
                'group' => 'social',
                'label' => 'LinkedIn Profile URL',
                'type' => 'text',
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://www.facebook.com/nusantaralng',
                'group' => 'social',
                'label' => 'Facebook URL',
                'type' => 'text',
            ],
            [
                'key' => 'social_pinterest',
                'value' => 'https://twitter.com/nusantaralng',
                'group' => 'social',
                'label' => 'X / Twitter URL',
                'type' => 'text',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://www.youtube.com/@nusantaralngenergi',
                'group' => 'social',
                'label' => 'YouTube Channel URL',
                'type' => 'text',
            ],
            [
                'key' => 'footer_copyright',
                'value' => 'Copyright © 2026 PT Nusantara LNG Energi. All rights reserved.',
                'group' => 'general',
                'label' => 'Footer Copyright Text',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
