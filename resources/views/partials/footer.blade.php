<footer class="bg-black text-neutral-300 pt-20 pb-12 border-t border-neutral-900">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        
        <!-- Top Row: Brand & Social Icons -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between pb-14 border-b border-neutral-900 gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3 tracking-widest2 uppercase font-bold text-white group">
                <div class="w-8 h-8 bg-white text-black flex items-center justify-center font-bold text-xs tracking-tighter">
                    N
                </div>
                <div>
                    <div class="text-sm font-extrabold tracking-[0.22em]">NUSANTARA LNG</div>
                    <div class="text-[9px] text-neutral-400 tracking-widest font-normal">INTEGRATED CLEAN ENERGY &amp; CRYOGENICS</div>
                </div>
            </a>

            <!-- Social Links -->
            <div class="flex items-center space-x-5 text-neutral-400">
                @if($ig = \App\Models\SiteSetting::get('social_instagram'))
                    <a href="{{ $ig }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" aria-label="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                @endif
                @if($fb = \App\Models\SiteSetting::get('social_facebook'))
                    <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                    </a>
                @endif
                @if($pin = \App\Models\SiteSetting::get('social_pinterest'))
                    <a href="{{ $pin }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" aria-label="X Twitter">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                @endif
                @if($yt = \App\Models\SiteSetting::get('social_youtube'))
                    <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Middle Row: 4 Column Navigation & Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 py-14 border-b border-neutral-900 text-xs">
            
            <!-- Column 1: Corporate Profile -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Corporate Profile</h4>
                <p class="text-neutral-400 text-[11px] leading-relaxed">
                    {{ \App\Models\SiteSetting::get('company_description', 'PT Nusantara LNG Energi is Indonesia’s integrated cryogenic clean energy infrastructure provider, delivering LNG supply, virtual pipelines, and industrial regasification solutions.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ url('/about-us') }}" class="inline-block text-[11px] uppercase tracking-widest font-semibold text-white border-b border-white hover:text-accent hover:border-accent transition-colors pb-0.5">
                        Company Overview &rarr;
                    </a>
                </div>
            </div>

            <!-- Column 2: Jakarta Headquarters -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Headquarters</h4>
                <p class="text-neutral-400 text-[11px] leading-relaxed whitespace-pre-line">
                    {{ \App\Models\SiteSetting::get('company_address', "PT Nusantara LNG Energi\nMenara Gas & Energi Indonesia, 28th Floor\nKawasan SCBD Lot 11, Jl. Jend. Sudirman Kav. 52-53\nJakarta Selatan 12190, Indonesia") }}
                </p>
                <a href="{{ \App\Models\SiteSetting::get('company_directions_url', 'https://maps.google.com/?q=SCBD+Jakarta') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="inline-block text-[11px] uppercase tracking-widest font-semibold text-white border-b border-white hover:text-accent hover:border-accent transition-colors pb-0.5">
                    View on Maps &rarr;
                </a>
            </div>

            <!-- Column 3: Commercial & Inquiries -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Commercial &amp; Offtake</h4>
                <ul class="space-y-2 text-neutral-400 text-[11px]">
                    @if($p1 = \App\Models\SiteSetting::get('company_phone_1', '+62 21 5289 7700'))
                        <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $p1) }}" class="hover:text-white transition-colors">Tel: {{ $p1 }}</a></li>
                    @endif
                    @if($p2 = \App\Models\SiteSetting::get('company_phone_2', '+62 21 5289 7701'))
                        <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $p2) }}" class="hover:text-white transition-colors">Tel: {{ $p2 }}</a></li>
                    @endif
                    @if($wa = \App\Models\SiteSetting::get('company_whatsapp', '+6281188997700'))
                        <li><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wa) }}" target="_blank" class="hover:text-white transition-colors">WA: {{ $wa }}</a></li>
                    @endif
                    @if($emMkt = \App\Models\SiteSetting::get('company_email_marketing', 'commercial@nusantara-lng.com'))
                        <li class="pt-2"><a href="mailto:{{ $emMkt }}" class="text-white hover:text-accent transition-colors">{{ $emMkt }}</a></li>
                    @endif
                    @if($emInfo = \App\Models\SiteSetting::get('company_email_info', 'info@nusantara-lng.com'))
                        <li><a href="mailto:{{ $emInfo }}" class="text-neutral-400 hover:text-white transition-colors">{{ $emInfo }}</a></li>
                    @endif
                </ul>
            </div>

            <!-- Column 4: Quick Links (5 Core Structure) -->
            <div class="space-y-4">
                <h4 class="text-white uppercase tracking-widest2 font-semibold text-xs">Quick Links</h4>
                <ul class="space-y-2 text-[11px] uppercase tracking-wider text-neutral-400">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ url('/about-us') }}" class="hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-white transition-colors">Products &amp; Solutions</a></li>
                    <li><a href="{{ url('/our-blog') }}" class="hover:text-white transition-colors">Energy Insights</a></li>
                    <li><a href="{{ url('/contact-us') }}" class="hover:text-white transition-colors">Contact Commercial Desk</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom Row: Copyright -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-[11px] text-neutral-500 gap-4">
            <p>{{ \App\Models\SiteSetting::get('footer_copyright', 'Copyright © 2026 PT Nusantara LNG Energi. All rights reserved.') }}</p>
            <div class="flex items-center space-x-6 text-[10px] uppercase tracking-widest">
                <a href="{{ url('/admin/login') }}" class="text-neutral-600 hover:text-neutral-300 transition-colors">Admin Portal</a>
            </div>
        </div>

    </div>
</footer>
