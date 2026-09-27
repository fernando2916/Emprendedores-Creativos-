<div>
    <div class="swiper mySwiper-banner relative w-full h-100 md:h-197.5">
    <div class="swiper-wrapper">
        @foreach ($banners as $banner)
            <div class="swiper-slide relative">
                <img src="{{ $banner->banner ? Storage::url($banner->banner) : '' }}" alt="" class="w-full h-full object-cover">
            </div>           
        @endforeach
    </div>

    {{-- Paginación y navegación --}}
    <div class="swiper-pagination absolute bottom-5 w-full text-center z-10"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
</div>