<div>
    <div class="swiper mySwiper-banner relative">
    <div class="swiper-wrapper">
        @foreach ($banners as $banner)
            <div class="swiper-slide relative">
                <img src="{{ $banner->banner ? Storage::url($banner->banner) : '' }}" alt="" class="w-full h-96 object-cover">
                <div class="absolute top-5 md:top-10 left-0 w-full">
                    <div class="p-5 flex flex-col items-center md:items-start max-w-3xl mx-auto text-white">
                        <h3 class="text-xl md:text-4xl font-bold">{{ $banner->titulo }}</h3>
                        <p class="mt-2">{{ $banner->descripcion }}</p>
                        <a href="{{ route($banner->enlace) }}">
                            <button class="bg-btn-200 hover:bg-btn-400 dark:bg-btn-400 hover:dark:bg-btn-600 transition-colors duration-150 p-3 rounded-md cursor-pointer font-semibold mt-4">
                                Visitar
                            </button>
                        </a>
                    </div>
                </div>
            </div>           
        @endforeach
    </div>

    {{-- Paginación y navegación --}}
    <div class="swiper-pagination absolute bottom-5 w-full text-center z-10"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
</div>