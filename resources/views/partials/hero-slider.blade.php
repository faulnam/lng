@props(['slides' => [], 'page' => 'home'])

<section class="relative w-full bg-black text-white overflow-hidden">
    <!-- Swiper Container -->
    <div class="swiper heroSwiper w-full h-[75vh] md:h-[85vh] lg:h-[90vh]">
        <div class="swiper-wrapper">
            @forelse($slides as $slide)
                <div class="swiper-slide relative flex items-center justify-center">
                    <!-- Slide Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 scale-100" 
                         style="background-image: url('{{ app_image($slide->image, 'images/lng/carrier.jpg') }}');">
                    </div>
                    
                    <!-- Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/50"></div>

                    <!-- Slide Content -->
                    <div class="relative z-10 max-w-5xl mx-auto px-6 md:px-12 text-center space-y-6 pt-16">
                        @if($slide->subtitle)
                            <div class="eyebrow-light tracking-widest3 animate-fade-in">
                                {{ $slide->subtitle }}
                            </div>
                        @endif

                        @if($slide->title)
                            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                                {{ $slide->title }}
                            </h2>
                        @endif

                        @if($slide->button_text && $slide->button_link)
                            <div class="pt-4">
                                <a href="{{ url($slide->button_link) }}" class="btn-outline">
                                    {{ $slide->button_text }} &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Fallback Default Slide -->
                <div class="swiper-slide relative flex items-center justify-center">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=1920&auto=format&fit=crop');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/50"></div>
                    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center space-y-6 pt-16">
                        <div class="eyebrow-light tracking-widest3">Restaurant & Bar Interior Architecture</div>
                        <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight uppercase">
                            Burger & Lobster &bull; Plaza Indonesia
                        </h2>
                        <div class="pt-4">
                            <a href="{{ url('/services') }}" class="btn-outline">
                                View Project &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Slider Pagination & Navigation Arrows -->
        <div class="swiper-pagination !bottom-8"></div>
        <div class="swiper-button-prev !text-white !hidden md:!flex !left-8 after:!text-lg"></div>
        <div class="swiper-button-next !text-white !hidden md:!flex !right-8 after:!text-lg"></div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.heroSwiper', {
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
    });
</script>
@endpush
