<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds for LNG Products & Solutions.
     */
    public function run(): void
    {
        // 1. Parent: Bulk Liquefied Natural Gas (LNG)
        $bulkLng = Service::updateOrCreate(
            ['slug' => 'bulk-lng-supply'],
            [
                'parent_id' => null,
                'title' => 'Bulk LNG Supply & Trading',
                'excerpt' => 'Large-scale cargo offtake and international shipping solutions under flexible FOB and DES commercial frameworks.',
                'description' => 'We supply high-calorific liquefied natural gas sourced from tier-1 liquefaction trains, offering secure global shipping schedules and robust contractual terms for national utilities and multinational off-takers.',
                'icon' => 'globe-alt',
                'order' => 1,
                'is_active' => true,
            ]
        );

        // Sub-categories under Bulk LNG
        $bulkSubServices = [
            [
                'title' => 'FOB Cargo Offtake',
                'slug' => 'fob-cargo-offtake',
                'excerpt' => 'Direct vessel loading at major liquefaction berths with certified cryogenic custody transfer.',
                'description' => 'Free-On-Board (FOB) contracts enabling charterers and international energy traders to lift LNG cargoes directly with full volume flexibility.',
                'order' => 1,
            ],
            [
                'title' => 'DES Regas Terminal Delivery',
                'slug' => 'des-terminal-delivery',
                'excerpt' => 'Delivered-Ex-Ship (DES) cargo supply to onshore receiving terminals and Floating Storage Regasification Units (FSRU).',
                'description' => 'Turnkey delivery where Nusantara LNG coordinates cryogenic vessel chartering, boil-off gas optimization, and jetty discharge management.',
                'order' => 2,
            ],
            [
                'title' => 'Long-Term & Spot Supply Contracts',
                'slug' => 'term-spot-contracts',
                'excerpt' => 'Multi-year indexed agreements and spot cargo availability matching peak seasonal industrial demand.',
                'description' => 'Customized pricing formulas indexed to Brent, JKM, or Henry Hub with reliable take-or-pay flexibility designed for power producers.',
                'order' => 3,
            ],
        ];

        foreach ($bulkSubServices as $sub) {
            Service::updateOrCreate(
                ['slug' => $sub['slug']],
                [
                    'parent_id' => $bulkLng->id,
                    'title' => $sub['title'],
                    'excerpt' => $sub['excerpt'],
                    'description' => $sub['description'],
                    'order' => $sub['order'],
                    'is_active' => true,
                ]
            );
        }

        // 2. Parent: Small-Scale LNG & Virtual Pipeline
        $virtualPipeline = Service::updateOrCreate(
            ['slug' => 'small-scale-virtual-pipeline'],
            [
                'parent_id' => null,
                'title' => 'Small-Scale LNG & Virtual Pipeline',
                'excerpt' => 'Multimodal ISO tank distribution delivering clean gas to remote industrial clusters, smelters, and off-grid power grids.',
                'description' => 'Our virtual pipeline bridges archipelago geography without expensive subsea pipelines, utilizing specialized 20ft/40ft T75 cryogenic ISO containers with integrated real-time telemetry.',
                'icon' => 'truck',
                'order' => 2,
                'is_active' => true,
            ]
        );

        // Sub-categories under Virtual Pipeline
        $vpSubServices = [
            [
                'title' => 'Cryogenic ISO Tank Fleet',
                'slug' => 'cryogenic-iso-tank-fleet',
                'excerpt' => 'High-specification IMO 7 / T75 cryogenic container fleet engineered for multimodal land and sea transport.',
                'description' => 'Super-insulated double-wall vacuum containers ensuring up to 90 days holding time without venting, tracked with IoT GPS and pressure monitoring.',
                'order' => 1,
            ],
            [
                'title' => 'Captive Power & Smelter Fuel Supply',
                'slug' => 'captive-power-smelter-fuel',
                'excerpt' => 'Dedicated supply logistics powering mining smelters and independent power producers (IPP).',
                'description' => 'High-reliability continuous supply schemes replacing diesel (HSD/MFO) with clean natural gas to cut operational fuel costs by up to 35%.',
                'order' => 2,
            ],
            [
                'title' => 'Industrial Off-Grid Regasification Skids',
                'slug' => 'industrial-regas-skids',
                'excerpt' => 'Compact plug-and-play cryogenic storage and ambient air vaporization units installed directly at factory sites.',
                'description' => 'On-site turnkey regasification systems engineered for manufacturing plants, textile factories, ceramics, and food processing.',
                'order' => 3,
            ],
        ];

        foreach ($vpSubServices as $sub) {
            Service::updateOrCreate(
                ['slug' => $sub['slug']],
                [
                    'parent_id' => $virtualPipeline->id,
                    'title' => $sub['title'],
                    'excerpt' => $sub['excerpt'],
                    'description' => $sub['description'],
                    'order' => $sub['order'],
                    'is_active' => true,
                ]
            );
        }

        // 3. Parent: LNG Marine Bunkering
        Service::updateOrCreate(
            ['slug' => 'lng-marine-bunkering'],
            [
                'parent_id' => null,
                'title' => 'LNG Marine Bunkering',
                'excerpt' => 'Eco-friendly maritime refueling services complying with IMO 2030/2050 sulfur emission regulations.',
                'description' => 'Ship-to-Ship (STS) and Truck-to-Ship (TTS) LNG bunkering infrastructure for commercial container fleets, bulk carriers, and passenger vessels operating along strategic straits.',
                'icon' => 'anchor',
                'order' => 3,
                'is_active' => true,
            ]
        );

        // 4. Parent: Terminal & Regasification Operations
        Service::updateOrCreate(
            ['slug' => 'terminal-regasification-operations'],
            [
                'parent_id' => null,
                'title' => 'Terminal & Regasification Operations',
                'excerpt' => 'FSRU management, coastal storage terminal throughput, and high-pressure pipeline injection.',
                'description' => 'Comprehensive operation and maintenance of cryogenic storage tanks, boil-off gas reliquefaction systems, and open-rack seawater vaporizers.',
                'icon' => 'building-office',
                'order' => 4,
                'is_active' => true,
            ]
        );

        // 5. Parent: Cryogenic EPC & Technical Consultation
        Service::updateOrCreate(
            ['slug' => 'cryogenic-epc-consultation'],
            [
                'parent_id' => null,
                'title' => 'Cryogenic EPC & Technical Consultation',
                'excerpt' => 'Turnkey engineering, procurement, construction, and QHSE compliance for industrial cryogenic gas facilities.',
                'description' => 'Specialized engineering advisory covering thermal insulation analysis, HAZOP risk assessment, pipeline stress calculation, and SIGTTO safety certification.',
                'icon' => 'cog',
                'order' => 5,
                'is_active' => true,
            ]
        );
    }
}
