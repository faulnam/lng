<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Client;
use App\Models\HeroSlide;
use App\Models\JobVacancy;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hero Slides (LNG Themed)
        $heroSlides = [
            [
                'page' => 'home',
                'title' => 'Integrated LNG Fleet & Global Shipping Logistics',
                'subtitle' => 'Reliable Cryogenic Supply Chains for Power Utilities and Global Offtakers',
                'button_text' => 'Explore Bulk Supply',
                'button_link' => '/services/bulk-lng-supply',
                'image' => '/images/lng/carrier.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'title' => 'Strategic Coastal Regasification & Terminal Networks',
                'subtitle' => 'High-Throughput Vaporization and FSRU Infrastructure Connecting Energy Corridors',
                'button_text' => 'View Terminals',
                'button_link' => '/services/terminal-regasification-operations',
                'image' => '/images/lng/terminal.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'title' => 'Multimodal Virtual Pipeline & ISO Tank Distribution',
                'subtitle' => 'Delivering Clean Natural Gas to Off-Grid Smelters, Captive Power, and Heavy Industry',
                'button_text' => 'Virtual Pipeline',
                'button_link' => '/services/small-scale-virtual-pipeline',
                'image' => '/images/lng/iso_tanks.jpg',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($heroSlides as $slide) {
            HeroSlide::updateOrCreate(
                ['title' => $slide['title'], 'page' => $slide['page']],
                $slide
            );
        }

        // 2. Offtakers & Strategic Partners (Clients)
        $clients = [
            ['name' => 'PT PLN Indonesia Power', 'logo' => null, 'website_url' => 'https://indonesiapower.co.id', 'order' => 1],
            ['name' => 'PT Pertamina Gas Negara (PGN)', 'logo' => null, 'website_url' => 'https://pgn.co.id', 'order' => 2],
            ['name' => 'PT Pupuk Indonesia', 'logo' => null, 'website_url' => 'https://pupuk-indonesia.com', 'order' => 3],
            ['name' => 'Semen Indonesia Group (SIG)', 'logo' => null, 'website_url' => 'https://sig.id', 'order' => 4],
            ['name' => 'Marubeni Energy Asia', 'logo' => null, 'website_url' => 'https://marubeni.com', 'order' => 5],
            ['name' => 'Tokyo Gas Global Services', 'logo' => null, 'website_url' => 'https://tokyo-gas.co.jp', 'order' => 6],
            ['name' => 'SKK Migas Certified', 'logo' => null, 'website_url' => 'https://skkmigas.go.id', 'order' => 7],
            ['name' => 'SIGTTO & GIIGNL Member', 'logo' => null, 'website_url' => 'https://sigtto.org', 'order' => 8],
        ];

        foreach ($clients as $c) {
            Client::updateOrCreate(['name' => $c['name']], $c);
        }

        // 3. Products & Business Solutions (Projects)
        $bulkService = Service::where('slug', 'bulk-lng-supply')->first() ?? Service::first();
        $vpService = Service::where('slug', 'small-scale-virtual-pipeline')->first() ?? Service::first();
        $bunkerService = Service::where('slug', 'lng-marine-bunkering')->first() ?? Service::first();
        $terminalService = Service::where('slug', 'terminal-regasification-operations')->first() ?? Service::first();
        $epcService = Service::where('slug', 'cryogenic-epc-consultation')->first() ?? Service::first();

        $projects = [
            [
                'service_id' => $bulkService->id,
                'title' => 'Bulk LNG Cargo Supply — FOB & DES Offtake',
                'slug' => 'bulk-lng-cargo-supply',
                'client' => 'Regional Power Utilities & Traders',
                'location' => 'Bontang & Tangguh Loading Berths',
                'size' => '2.4 MTPA Capacity',
                'year' => '2024',
                'description' => '<p>Large-scale long-term and spot LNG cargo supplies certified under international custody transfer standards. Sourced from high-efficiency liquefaction trains with typical Gross Heating Value of 1,020 - 1,140 BTU/SCF.</p><p>We provide flexible lifting programs accommodating standard 125,000 - 174,000 m³ Q-Flex and conventional LNG carriers with certified boil-off gas management.</p>',
                'cover_image' => '/images/lng/carrier.jpg',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 1,
                'status' => 'published',
            ],
            [
                'service_id' => $terminalService->id,
                'title' => 'FSRU Jawa Satu High-Pressure Regasification',
                'slug' => 'fsru-jawa-satu-regasification',
                'client' => 'National Power Grid Offtaker',
                'location' => 'North West Java Offshore',
                'size' => '500 MMSCFD Peak Sendout',
                'year' => '2024',
                'description' => '<p>Continuous offshore regasification and high-pressure subsea pipeline injection directly supplying combined-cycle IPP power stations. Incorporates seawater open-rack vaporization and closed-loop glycol heat exchanger technology with 99.99% availability.</p>',
                'cover_image' => '/images/lng/terminal.jpg',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 2,
                'status' => 'published',
            ],
            [
                'service_id' => $vpService->id,
                'title' => 'Virtual Pipeline ISO Tank Fleet — Smelter Energy Hub',
                'slug' => 'virtual-pipeline-iso-tank-smelter-hub',
                'client' => 'Mineral Processing & Nickel Smelter Consortium',
                'location' => 'Morowali & Weda Bay, Sulawesi-Maluku',
                'size' => '250 ISO Containers / Month',
                'year' => '2024',
                'description' => '<p>End-to-end cryogenic intermodal ISO container distribution delivering LNG from central liquefaction hubs to remote captive power plants and rotary kiln electric furnaces. Guaranteed holding time up to 90 days with IoT telemetry for pressure, temperature, and GPS coordinates.</p>',
                'cover_image' => '/images/lng/iso_tanks.jpg',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 3,
                'status' => 'published',
            ],
            [
                'service_id' => $bunkerService->id,
                'title' => 'Malacca Strait Ship-to-Ship (STS) LNG Bunkering',
                'slug' => 'malacca-strait-sts-lng-bunkering',
                'client' => 'International Container Line Operators',
                'location' => 'Singapore-Malacca Strait Anchorage',
                'size' => '120,000 m³ Bunkered Annually',
                'year' => '2024',
                'description' => '<p>Dedicated 7,500 m³ LNG bunker vessel conducting fast, low-emission cryogenic ship-to-ship refueling. Compliant with SGX/MPA and SIGTTO marine safety protocols, cutting sulfur oxide (SOx) by 99% and carbon emissions by 25% for ocean-going container vessels.</p>',
                'cover_image' => '/images/lng/bunkering.jpg',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 4,
                'status' => 'published',
            ],
            [
                'service_id' => $terminalService->id,
                'title' => 'Coastal Cryogenic Storage & Regasification Terminal',
                'slug' => 'coastal-cryogenic-storage-terminal',
                'client' => 'Industrial Gas Distribution Network',
                'location' => 'Teluk Lamong, East Java',
                'size' => '100,000 m³ Full Containment Tank',
                'year' => '2023',
                'description' => '<p>Turnkey coastal hub featuring 9% nickel steel inner cryogenic tanks and prestressed concrete outer containment. Provides regional peak-shaving, truck loading bays, and high-pressure custody metering for manufacturing estates.</p>',
                'cover_image' => '/images/lng/regas_plant.jpg',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 5,
                'status' => 'published',
            ],
            [
                'service_id' => $epcService->id,
                'title' => 'SCADA & Cryogenic Process Automation Center',
                'slug' => 'scada-cryogenic-process-automation',
                'client' => 'Corporate Energy Command Hub',
                'location' => 'Jakarta Headquarters & Regional Hubs',
                'size' => '24/7 Real-Time Telemetry',
                'year' => '2024',
                'description' => '<p>Integrated supervisory control and predictive AI telemetry monitoring nationwide cryogenic pressure vessels, liquefaction boil-off rates, and marine vessel navigation tracks in full compliance with ISO 27001 and IEC 61508 safety standards.</p>',
                'cover_image' => '/images/lng/control_center.jpg',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 6,
                'status' => 'published',
            ],
            [
                'service_id' => $vpService->id,
                'title' => 'Bintan Island Resort Microgrid Regasification Skid',
                'slug' => 'bintan-resort-microgrid-regas-skid',
                'client' => 'Hospitality & Captive Utility Authority',
                'location' => 'Lagoi, Bintan Island',
                'size' => '15 MMSCFD Skid Capacity',
                'year' => '2024',
                'description' => '<p>Compact plug-and-play ambient air regasification unit replacing heavy fuel oil generators. Delivers continuous natural gas feed for eco-resort tri-generation systems (power, steam, and chilled water).</p>',
                'cover_image' => '/images/lng/iso_tanks.jpg',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 7,
                'status' => 'published',
            ],
            [
                'service_id' => $bulkService->id,
                'title' => 'Pacific Corridor Spot & Term Portfolio Offtake',
                'slug' => 'pacific-corridor-spot-term-offtake',
                'client' => 'East Asia Power & Gas Conglomerate',
                'location' => 'Japan - South Korea - Taiwan (JKT) Corridor',
                'size' => '1.2 MTPA Indexed Supply',
                'year' => '2023',
                'description' => '<p>Multi-year portfolio contract indexed to JKM and Brent pricing with seasonal flexibility clauses, providing buffer security for extreme winter peak demand in Northeast Asian receiving terminals.</p>',
                'cover_image' => '/images/lng/carrier.jpg',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 8,
                'status' => 'published',
            ],
            [
                'service_id' => $epcService->id,
                'title' => 'Cryogenic Boil-Off Gas (BOG) Reliquefaction Unit EPC',
                'slug' => 'cryogenic-bog-reliquefaction-unit-epc',
                'client' => 'Petrochemical Manufacturing Complex',
                'location' => 'Gresik, East Java',
                'size' => '20 Tons/Day BOG Recovery',
                'year' => '2024',
                'description' => '<p>Engineering, procurement, and commissioning of high-efficiency cryogenic Stirling cycle reliquefaction skid, recovering 100% of boil-off gas without flaring to achieve zero fugitive methane emissions.</p>',
                'cover_image' => '/images/lng/regas_plant.jpg',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 9,
                'status' => 'published',
            ],
        ];

        foreach ($projects as $pData) {
            $proj = Project::updateOrCreate(['slug' => $pData['slug']], $pData);

            // Add gallery images
            if ($proj->images()->count() === 0) {
                ProjectImage::create([
                    'project_id' => $proj->id,
                    'image_path' => $pData['cover_image'],
                    'order' => 1,
                ]);
                ProjectImage::create([
                    'project_id' => $proj->id,
                    'image_path' => '/images/lng/terminal.jpg',
                    'order' => 2,
                ]);
                ProjectImage::create([
                    'project_id' => $proj->id,
                    'image_path' => '/images/lng/control_center.jpg',
                    'order' => 3,
                ]);
            }
        }

        // 4. Blog Categories & Posts (Energy Themed)
        $catInsights = BlogCategory::updateOrCreate(['slug' => 'energy-market-insights'], ['title' => 'Energy Market Insights']);
        $catPolicy = BlogCategory::updateOrCreate(['slug' => 'policy-energy-transition'], ['title' => 'Policy & Energy Transition']);
        $catQhse = BlogCategory::updateOrCreate(['slug' => 'cryogenic-tech-qhse'], ['title' => 'Cryogenic Tech & QHSE']);
        $catCorp = BlogCategory::updateOrCreate(['slug' => 'corporate-news'], ['title' => 'Corporate & Offtake News']);

        $blogPosts = [
            [
                'blog_category_id' => $catInsights->id,
                'title' => 'Global LNG Market Outlook 2025-2030: Expanding Southeast Asia Offtake Demand',
                'slug' => 'global-lng-market-outlook-2025-2030',
                'excerpt' => 'An in-depth analysis of emerging demand drivers in Indonesia, Vietnam, and the Philippines as coal-to-gas switching accelerates.',
                'content' => '<p>As Southeast Asian economies pursue industrialization alongside ambitious net-zero targets, liquefied natural gas (LNG) has emerged as the definitive baseload bridge fuel. Coal-to-gas transition across regional power generation grids requires over 25 MTPA of incremental regasification capacity by 2030.</p><p>Nusantara LNG is strategically positioning flexible supply portfolios and modular coastal terminals to meet this surging demand with indexed price certainty.</p>',
                'cover_image' => '/images/lng/carrier.jpg',
                'author' => 'Nusantara LNG Research Desk',
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'blog_category_id' => $catPolicy->id,
                'title' => 'Virtual Pipeline Economics: How Cryogenic ISO Tanks Unlock Remote Industrial Decarbonization',
                'slug' => 'virtual-pipeline-economics-iso-tanks',
                'excerpt' => 'Exploring how multimodal ISO container logistics eliminates the capital expenditure barrier of traditional subsea pipeline projects.',
                'content' => '<p>In archipelagic geographies, traditional pipeline infrastructure is often commercially and geographically unfeasible. The virtual pipeline model—utilizing vacuum-insulated T75 ISO tank containers via roll-on/roll-off shipping and road trucking—delivers high-purity natural gas directly to factory gates and mining smelters.</p><p>Industrial offtakers report average operating fuel cost reductions of 28% to 35% compared to industrial diesel, while slashing particulate emissions by 99%.</p>',
                'cover_image' => '/images/lng/iso_tanks.jpg',
                'author' => 'Commercial Logistics Strategy',
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'blog_category_id' => $catQhse->id,
                'title' => 'Zero-Incident Cryogenic Operations: Upholding SIGTTO Protocols in Marine Bunkering',
                'slug' => 'zero-incident-cryogenic-operations-sigtto',
                'excerpt' => 'A technical overview of cryogenic safety barriers, emergency release systems (ERS), and ESD-2 protocols during ship-to-ship LNG transfer.',
                'content' => '<p>Cryogenic handling of liquefied methane at -162°C requires uncompromising process safety rigor. Nusantara LNG maintains compliance with SIGTTO, SGMF, and ISO 20519 international guidelines across all marine and onshore bunkering facilities.</p><p>Through automated Emergency Shutdown (ESD) interlocks and real-time infrared gas leak detection, our operations maintain an exemplary record of over 15 million safe working hours without Lost Time Incidents (LTI).</p>',
                'cover_image' => '/images/lng/control_center.jpg',
                'author' => 'QHSE & Marine Technical Division',
                'is_published' => true,
                'published_at' => now()->subDays(22),
            ],
            [
                'blog_category_id' => $catCorp->id,
                'title' => 'Nusantara LNG Signs 10-Year Offtake Agreement with National Industrial Smelter Consortium',
                'slug' => 'nusantara-lng-signs-10-year-offtake-agreement',
                'excerpt' => 'Long-term partnership secures 600,000 tonnes per annum of dedicated LNG supply for eastern Indonesian mineral processing facilities.',
                'content' => '<p>PT Nusantara LNG Energi has formalized a 10-year liquefied natural gas supply contract with leading nickel and copper refining groups in Sulawesi and Maluku. The agreement encompasses the deployment of 150 new cryogenic ISO containers and the installation of two on-site ambient air regasification skids.</p><p>This landmark partnership underscores our role as Indonesia’s most reliable partner for industrial energy security.</p>',
                'cover_image' => '/images/lng/terminal.jpg',
                'author' => 'Corporate Communications',
                'is_published' => true,
                'published_at' => now()->subDays(35),
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 5. Awards & Accreditations (LNG Themed)
        $awards = [
            [
                'title' => 'ISO 9001:2015 & ISO 45001:2018 Certified Cryogenic Management',
                'slug' => 'iso-quality-occupational-safety-certification',
                'image' => '/images/lng/control_center.jpg',
                'description' => 'Accredited for world-class quality assurance and occupational health & safety management in cryogenic gas handling and terminal operations.',
                'external_link' => 'https://iso.org',
                'published_date' => '2024-06-15',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'SIGTTO Excellence in Marine Cryogenic Operations',
                'slug' => 'sigtto-excellence-marine-cryogenic-award',
                'image' => '/images/lng/bunkering.jpg',
                'description' => 'Recognized by the Society of International Gas Tanker and Terminal Operators for flawless ship-to-ship LNG transfer safety standards.',
                'external_link' => 'https://sigtto.org',
                'published_date' => '2023-11-20',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'ESDM Clean Energy Transition Catalyst Award 2024',
                'slug' => 'esdm-clean-energy-transition-award',
                'image' => '/images/lng/terminal.jpg',
                'description' => 'Awarded by the Ministry of Energy and Mineral Resources for pioneering virtual pipeline distribution to off-grid industrial smelters.',
                'external_link' => 'https://esdm.go.id',
                'published_date' => '2024-08-17',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($awards as $aw) {
            Award::updateOrCreate(['slug' => $aw['slug']], $aw);
        }

        // 6. Job Vacancies
        $jobs = [
            [
                'title' => 'Senior Cryogenic Process Engineer (LNG Regasification)',
                'slug' => 'senior-cryogenic-process-engineer',
                'responsibilities' => "Oversee thermodynamic process design and operations for LNG ambient air and seawater vaporizers.\nConduct HAZOP, SIL risk assessments, and boil-off gas (BOG) calculation modeling.\nLead technical coordination with terminal EPC contractors, SKK Migas regulators, and client technical teams.",
                'requirements' => "Bachelor's / Master's in Chemical Engineering, Mechanical Engineering, or Cryogenic Engineering.\nMinimum 6+ years of operational or design experience in LNG liquefaction, FSRU, or cryogenic storage.\nProficiency in Aspen HYSYS, PRO/II, and international codes (ASME B31.3, NFPA 59A, EN 1473).\nFluent in professional English and Bahasa Indonesia.",
                'email_subject' => 'Application for Senior Cryogenic Engineer - [Your Name]',
                'posted_at' => now()->subDays(7),
                'is_active' => true,
            ],
            [
                'title' => 'Marine Logistics & LNG Bunkering Operations Manager',
                'slug' => 'marine-logistics-bunkering-manager',
                'responsibilities' => "Manage commercial vessel scheduling, cryogenic bunkering transfers, and port clearance procedures.\nEnsure strict compliance with SIGTTO, SGMF, and international maritime safety codes.\nOptimize chartering economics, boil-off mitigation, and custody transfer billing.",
                'requirements' => "Master Mariner / Class 1 Marine Engineer certification or Bachelor's in Marine Transportation/Logistics.\nMinimum 5+ years experience on LNG carriers, bunker vessels, or coastal gas terminal operations.\nStrong leadership, crisis management, and commercial negotiation capabilities.",
                'email_subject' => 'Application for Marine Logistics Manager - [Your Name]',
                'posted_at' => now()->subDays(14),
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $j) {
            JobVacancy::updateOrCreate(['slug' => $j['slug']], $j);
        }

        // 7. Testimonials (B2B Offtakers & Partners)
        $testimonials = [
            [
                'client_name' => 'Ir. Bambang Haryanto',
                'client_company' => 'VP Energy Supply, Regional Power Generation Utility',
                'message' => 'Nusantara LNG’s virtual pipeline supply has maintained an uninterrupted 99.98% gas feed for our 350MW combined-cycle turbines. Their cryogenic delivery precision significantly reduced our fuel expenditure while slashing carbon emissions.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Capt. Hendrik Visser',
                'client_company' => 'Director of Maritime Operations, Pacific Container Lines',
                'message' => 'Their ship-to-ship LNG bunkering operations in the Malacca Strait adhere to the highest international SIGTTO safety standards. Transfer pumping rates, boil-off management, and turnaround efficiency are exemplary.',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Dr. Ir. Suryadi Pratama',
                'client_company' => 'Head of Plant Infrastructure, Eastern Indonesia Smelter Hub',
                'message' => 'Transitioning our mineral calcination furnaces to Nusantara LNG cryogenic ISO tanks provided instant thermal stability and lowered fuel costs by 32%. They are the gold standard in clean energy supply.',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }
    }
}
