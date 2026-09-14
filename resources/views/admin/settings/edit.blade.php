@extends('layouts.admin')

@section('title', 'Global Site Settings')
@section('page_title', 'Site Settings & Information')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-10">
        @csrf
        @method('PUT')

        <!-- Section 1: Key Statistics (Dynamic Counters) -->
        <div class="space-y-6">
            <div class="border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest2 font-bold text-white">
                    1. Key Performance Statistics
                </h3>
                <p class="text-[10px] text-neutral-400 mt-0.5">These dynamic numbers appear across the Homepage, About Us, and Footer statistics blocks.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label for="stat_years_exp" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Years of Experience
                    </label>
                    <input type="text" 
                           id="stat_years_exp" 
                           name="stat_years_exp" 
                           value="{{ old('stat_years_exp', $settings['stat_years_exp'] ?? '25+') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="stat_sqm_designed" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        m² Area Designed
                    </label>
                    <input type="text" 
                           id="stat_sqm_designed" 
                           name="stat_sqm_designed" 
                           value="{{ old('stat_sqm_designed', $settings['stat_sqm_designed'] ?? '1,200,000+') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="stat_hospitality_projects" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Hospitality &amp; F&amp;B Projects
                    </label>
                    <input type="text" 
                           id="stat_hospitality_projects" 
                           name="stat_hospitality_projects" 
                           value="{{ old('stat_hospitality_projects', $settings['stat_hospitality_projects'] ?? '500+') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="stat_awards_won" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Awards &amp; Accolades
                    </label>
                    <input type="text" 
                           id="stat_awards_won" 
                           name="stat_awards_won" 
                           value="{{ old('stat_awards_won', $settings['stat_awards_won'] ?? '80+') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>
        </div>

        <!-- Section 2: Company Identity & Information -->
        <div class="space-y-6">
            <div class="border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest2 font-bold text-white">
                    2. Company Identity &amp; Branding
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="company_name" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Company Name
                    </label>
                    <input type="text" 
                           id="company_name" 
                           name="company_name" 
                           value="{{ old('company_name', $settings['company_name'] ?? 'PT Nusantara LNG Energi') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="established_year" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Established Year
                    </label>
                    <input type="text" 
                           id="established_year" 
                           name="established_year" 
                           value="{{ old('established_year', $settings['established_year'] ?? '2008') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>

            <div>
                <label for="company_tagline" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Brand Tagline / Slogan
                </label>
                <input type="text" 
                       id="company_tagline" 
                       name="company_tagline" 
                       value="{{ old('company_tagline', $settings['company_tagline'] ?? 'Integrated Liquefied Natural Gas Infrastructure & Cryogenic Distribution Solutions') }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <!-- Section 3: Contact & Communication -->
        <div class="space-y-6">
            <div class="border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest2 font-bold text-white">
                    3. Contact Details &amp; Office Information
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contact_email" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Commercial Desk Email
                    </label>
                    <input type="email" 
                           id="contact_email" 
                           name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email'] ?? 'commercial@nusantara-lng.com') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="career_email" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Investor Relations Email
                    </label>
                    <input type="email" 
                           id="career_email" 
                           name="career_email" 
                           value="{{ old('career_email', $settings['career_email'] ?? 'investor.relations@nusantara-lng.com') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="contact_phone" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Telephone
                    </label>
                    <input type="text" 
                           id="contact_phone" 
                           name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone'] ?? '+62 21 5289 1234') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="contact_whatsapp" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Corporate Hotline
                    </label>
                    <input type="text" 
                           id="contact_whatsapp" 
                           name="contact_whatsapp" 
                           value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '+62 811 1234 5678') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="office_hours" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Office Operating Hours
                    </label>
                    <input type="text" 
                           id="office_hours" 
                           name="office_hours" 
                           value="{{ old('office_hours', $settings['office_hours'] ?? 'Mon - Fri: 08:30 - 17:30 WIB (Terminal Operations: 24/7)') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>

            <div>
                <label for="office_address" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Headquarters Address
                </label>
                <textarea id="office_address" 
                          name="office_address" 
                          rows="2" 
                          class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors">{{ old('office_address', $settings['office_address'] ?? 'Energy Tower Lt. 28, SCBD Lot 11A, Jl. Jend. Sudirman Kav. 52-53, Senayan, Kebayoran Baru, Jakarta Selatan 12190, Indonesia') }}</textarea>
            </div>
        </div>

        <!-- Section 4: Social Media Channels -->
        <div class="space-y-6">
            <div class="border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest2 font-bold text-white">
                    4. Social Media &amp; Portals
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="instagram_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Instagram URL
                    </label>
                    <input type="url" 
                           id="instagram_url" 
                           name="instagram_url" 
                           value="{{ old('instagram_url', $settings['instagram_url'] ?? 'https://instagram.com/nusantaralng') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="facebook_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Facebook URL
                    </label>
                    <input type="url" 
                           id="facebook_url" 
                           name="facebook_url" 
                           value="{{ old('facebook_url', $settings['facebook_url'] ?? 'https://facebook.com/nusantaralng') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="linkedin_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        LinkedIn URL
                    </label>
                    <input type="url" 
                           id="linkedin_url" 
                           name="linkedin_url" 
                           value="{{ old('linkedin_url', $settings['linkedin_url'] ?? 'https://linkedin.com/company/nusantara-lng-energi') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="youtube_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        YouTube URL
                    </label>
                    <input type="url" 
                           id="youtube_url" 
                           name="youtube_url" 
                           value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="pinterest_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Pinterest URL
                    </label>
                    <input type="url" 
                           id="pinterest_url" 
                           name="pinterest_url" 
                           value="{{ old('pinterest_url', $settings['pinterest_url'] ?? '') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>

                <div>
                    <label for="behance_url" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                        Behance URL
                    </label>
                    <input type="url" 
                           id="behance_url" 
                           name="behance_url" 
                           value="{{ old('behance_url', $settings['behance_url'] ?? '') }}" 
                           class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                </div>
            </div>
        </div>

        <!-- Section 5: Maps Embed Code -->
        <div class="space-y-6">
            <div class="border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest2 font-bold text-white">
                    5. Google Maps Embed
                </h3>
            </div>

            <div>
                <label for="google_maps_embed" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Google Maps Embed URL or iframe code
                </label>
                <textarea id="google_maps_embed" 
                          name="google_maps_embed" 
                          rows="3" 
                          placeholder="https://www.google.com/maps/embed?pb=..." 
                          class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors font-mono">{{ old('google_maps_embed', $settings['google_maps_embed'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end">
            <button type="submit" class="px-8 py-3.5 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Save All Site Settings &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
