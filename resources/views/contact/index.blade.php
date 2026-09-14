@extends('layouts.app')

@section('meta_title', 'Contact Us — ' . \App\Models\SiteSetting::get('company_name', 'PT Nusantara LNG Energi'))
@section('meta_description', 'Get in touch with PT Nusantara LNG Energi for commercial LNG offtake agreements, virtual pipeline logistics, or investor relations.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-neutral-900 text-white pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-60 scale-105 transform transition-transform duration-1000" 
             style="background-image: url('/images/lng/control_center.jpg');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/85"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-4">
            <div class="eyebrow-light">Commercial &amp; Corporate Inquiries</div>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                Contact Us
            </h1>
            <div class="min-h-[40px] flex items-center justify-center text-neutral-300 text-xs md:text-sm max-w-xl mx-auto"
                 x-data="{
                    text: '',
                    phrases: [
                        '{{ addslashes(\App\Models\PageContent::get('contact_intro_text', 'Connect directly with our commercial desk or logistics team for LNG supply agreements.')) }}',
                        'Discuss volume allocation, pricing formulas, and term structures.',
                        'Schedule an off-grid energy audit or virtual pipeline consultation.',
                        'Partnering for national energy resilience and sustainable industry.'
                    ],
                    phraseIndex: 0,
                    charIndex: 0,
                    isDeleting: false,
                    typeSpeed: 50,
                    deleteSpeed: 25,
                    pauseTime: 2000,
                    init() { this.type(); },
                    type() {
                        const current = this.phrases[this.phraseIndex];
                        if (this.isDeleting) {
                            this.text = current.substring(0, this.charIndex - 1);
                            this.charIndex--;
                        } else {
                            this.text = current.substring(0, this.charIndex + 1);
                            this.charIndex++;
                        }
                        let speed = this.isDeleting ? this.deleteSpeed : this.typeSpeed;
                        if (!this.isDeleting && this.charIndex === current.length) {
                            speed = this.pauseTime;
                            this.isDeleting = true;
                        } else if (this.isDeleting && this.charIndex === 0) {
                            this.isDeleting = false;
                            this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
                            speed = 350;
                        }
                        setTimeout(() => this.type(), speed);
                    }
                 }">
                <p class="leading-relaxed">
                    <span x-text="text">{{ \App\Models\PageContent::get('contact_intro_text', 'Connect directly with our commercial desk, logistics team, or investor relations office for LNG supply agreements, ISO tank delivery schedules, and partnership opportunities.') }}</span><span class="inline-block w-0.5 h-4 bg-white ml-1 align-middle animate-cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <!-- Main Contact Section (Grid: Left Details, Right Form) -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Details (5 cols) -->
                <div class="lg:col-span-5 space-y-10">
                    
                    <div>
                        <div class="eyebrow text-accent font-semibold mb-2">Corporate Office</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Jakarta Headquarters</h2>
                        <p class="mt-4 text-neutral-body text-xs md:text-sm leading-relaxed whitespace-pre-line">
                            {{ \App\Models\SiteSetting::get('company_address', "PT Nusantara LNG Energi\nMenara Gas & Energi Indonesia, 28th Floor\nKawasan SCBD Lot 11, Jl. Jend. Sudirman Kav. 52-53\nJakarta Selatan 12190, Indonesia") }}
                        </p>
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-4 pt-6 border-t border-neutral-200">
                        <div class="eyebrow text-[11px]">Direct Channels</div>
                        
                        <div class="space-y-3 text-xs">
                            @if($p1 = \App\Models\SiteSetting::get('company_phone_1'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-24">Headquarters:</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $p1) }}" class="hover:text-black transition-colors">{{ $p1 }}</a>
                                </div>
                            @endif

                            @if($p2 = \App\Models\SiteSetting::get('company_phone_2'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-24">Commercial:</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $p2) }}" class="hover:text-black transition-colors">{{ $p2 }}</a>
                                </div>
                            @endif

                            @if($wa = \App\Models\SiteSetting::get('company_whatsapp'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-24">WhatsApp Desk:</span>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wa) }}" target="_blank" class="text-emerald-700 font-semibold hover:underline">{{ $wa }}</a>
                                </div>
                            @endif

                            @if($e1 = \App\Models\SiteSetting::get('company_email_marketing'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-24">Commercial:</span>
                                    <a href="mailto:{{ $e1 }}" class="hover:text-black transition-colors">{{ $e1 }}</a>
                                </div>
                            @endif

                            @if($e2 = \App\Models\SiteSetting::get('company_email_hr'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-24">Investors:</span>
                                    <a href="mailto:{{ $e2 }}" class="hover:text-black transition-colors">{{ $e2 }}</a>
                                </div>
                            @endif

                            @if($e3 = \App\Models\SiteSetting::get('company_email_info'))
                                <div class="flex items-center gap-3 text-neutral-body">
                                    <span class="font-semibold text-black uppercase tracking-wider text-[10px] w-24">General Info:</span>
                                    <a href="mailto:{{ $e3 }}" class="hover:text-black transition-colors">{{ $e3 }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social / Professional Links -->
                    <div class="pt-6 border-t border-neutral-200 space-y-3">
                        <div class="eyebrow text-[11px]">Corporate Profiles</div>
                        <div class="flex items-center space-x-4 text-black">
                            @if($ig = \App\Models\SiteSetting::get('social_instagram'))
                                <a href="{{ $ig }}" target="_blank" class="p-2 border border-neutral-300 hover:border-black transition-colors" title="LinkedIn">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                            @if($fb = \App\Models\SiteSetting::get('social_facebook'))
                                <a href="{{ $fb }}" target="_blank" class="p-2 border border-neutral-300 hover:border-black transition-colors" title="Facebook">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                                </a>
                            @endif
                            @if($pin = \App\Models\SiteSetting::get('social_pinterest'))
                                <a href="{{ $pin }}" target="_blank" class="p-2 border border-neutral-300 hover:border-black transition-colors" title="X Twitter">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right Form (7 cols) -->
                <div class="lg:col-span-7 bg-neutral-bg p-8 md:p-12 border border-neutral-200">
                    <div class="space-y-2 mb-8">
                        <div class="eyebrow text-accent font-semibold">Supply &amp; Offtake Inquiries</div>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-black">Send Us An Inquiry</h2>
                    </div>

                    <form action="{{ url('/contact-us') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                Contact Representative Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   placeholder="e.g. Ir. Hendra Wicaksono" 
                                   class="w-full bg-white border @error('name') border-red-500 @else border-neutral-300 @enderror text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                            @error('name')
                                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                    Corporate Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       placeholder="name@company.com" 
                                       class="w-full bg-white border @error('email') border-red-500 @else border-neutral-300 @enderror text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                                @error('email')
                                    <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                    Company / Industrial Offtaker Name
                                </label>
                                <input type="text" 
                                       id="company" 
                                       name="company" 
                                       value="{{ old('company') }}" 
                                       placeholder="e.g. PT Sulawesi Smelter Power" 
                                       class="w-full bg-white border border-neutral-300 text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-[11px] uppercase tracking-wider font-semibold text-black mb-2">
                                Gas Supply Requirements &amp; Scope <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      placeholder="Please specify estimated gas volume (MMSCFD/MTPA), delivery location, delivery mode (Bulk Cargo / ISO Tank / Bunkering), and target operational timeline..." 
                                      class="w-full bg-white border @error('message') border-red-500 @else border-neutral-300 @enderror text-black text-xs px-4 py-3.5 focus:outline-none focus:border-black transition-colors">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn-dark w-full md:w-auto">
                                Submit Commercial Inquiry &rarr;
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Google Map Embed Section -->
    @if($mapUrl = \App\Models\SiteSetting::get('map_embed_url'))
        <section class="w-full h-96 bg-neutral-200 border-t border-neutral-300">
            <iframe src="{{ $mapUrl }}" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade" 
                    title="SCBD Office Location Map">
            </iframe>
        </section>
    @endif

@endsection
