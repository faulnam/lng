<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds for LNG Page Contents.
     */
    public function run(): void
    {
        $contents = [
            // Home Page
            [
                'key' => 'home_hero_title',
                'value' => 'Powering Global Industry with Integrated LNG & Cryogenic Energy Infrastructure',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Headline',
            ],
            [
                'key' => 'home_hero_description',
                'value' => 'PT Nusantara LNG Energi is an integrated liquefied natural gas (LNG) infrastructure and energy logistics corporation. We specialize in bulk LNG supply, virtual pipeline ISO tank distribution, coastal regasification terminals, and marine LNG bunkering. Our dependable cryogenic supply chain powers major electric utilities, smelters, and heavy industries across Southeast Asia and global trade corridors.',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Description',
            ],
            [
                'key' => 'home_recent_projects_eyebrow',
                'value' => 'Products & Business Lines',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Section Eyebrow',
            ],
            [
                'key' => 'home_recent_projects_subtitle',
                'value' => 'Engineered cryogenic solutions and flexible LNG supply agreements designed for utility and industrial offtakers.',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Section Subtitle',
            ],
            [
                'key' => 'home_latest_insights_eyebrow',
                'value' => 'Energy Insights & Market Publications',
                'page' => 'home',
                'section' => 'latest_insights',
                'label' => 'Latest Insights Section Eyebrow',
            ],
            [
                'key' => 'home_latest_insights_subtitle',
                'value' => 'Stay informed with our global gas market intelligence, regulatory analysis, and decarbonization outlooks.',
                'page' => 'home',
                'section' => 'latest_insights',
                'label' => 'Latest Insights Section Subtitle',
            ],
            [
                'key' => 'home_clients_eyebrow',
                'value' => 'Strategic Offtakers & Industry Affiliations',
                'page' => 'home',
                'section' => 'clients',
                'label' => 'Our Clients Section Eyebrow',
            ],
            [
                'key' => 'home_cta_title',
                'value' => 'Secure Your Long-Term LNG Supply Partner',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Title',
            ],
            [
                'key' => 'home_cta_subtitle',
                'value' => 'Discuss your energy volume requirements, virtual pipeline logistics, or term contract structures with our commercial team.',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Subtitle',
            ],

            // About Us Page
            [
                'key' => 'about_who_we_are_title',
                'value' => 'Who We Are',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Title',
            ],
            [
                'key' => 'about_who_we_are_text',
                'value' => 'PT Nusantara LNG Energi is an established energy infrastructure and liquefied natural gas provider with over 18 years of operational excellence in cryogenic transport and gas distribution. As a vital subsidiary in national energy security, we bridge upstream gas processing with downstream power generation, mineral refining, and maritime bunkering.',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Text',
            ],
            [
                'key' => 'about_mission_title',
                'value' => 'Our Strategic Mission & Vision',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Our Mission Title',
            ],
            [
                'key' => 'about_mission_text',
                'value' => 'To deliver secure, competitive, and cleaner energy solutions through world-class cryogenic logistics, accelerating sustainable industrial growth and regional energy transition with zero-incident safety standards.',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Our Mission Text',
            ],

            // Career Page (Maintained in DB)
            [
                'key' => 'career_intro_title',
                'value' => 'Join Our Energy Engineering Team',
                'page' => 'career',
                'section' => 'intro',
                'label' => 'Career - Intro Title',
            ],
            [
                'key' => 'career_intro_subtitle',
                'value' => 'We welcome world-class cryogenic engineers, logistics professionals, and energy analysts to drive sustainable gas infrastructure.',
                'page' => 'career',
                'section' => 'intro',
                'label' => 'Career - Intro Subtitle',
            ],

            // Contact Page
            [
                'key' => 'contact_intro_title',
                'value' => 'Corporate & Commercial Inquiries',
                'page' => 'contact',
                'section' => 'intro',
                'label' => 'Contact - Intro Title',
            ],
            [
                'key' => 'contact_intro_text',
                'value' => 'Connect directly with our commercial desk, logistics team, or investor relations office for LNG supply agreements, ISO tank delivery schedules, and partnership opportunities.',
                'page' => 'contact',
                'section' => 'intro',
                'label' => 'Contact - Intro Text',
            ],
        ];

        foreach ($contents as $item) {
            PageContent::updateOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
