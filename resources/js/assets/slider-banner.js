import Swiper from "swiper";
import { Pagination, Autoplay, Navigation } from "swiper/modules";
/* Swiper */
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/autoplay";

// Inicializa Swiper (puedes mover esto al DOMContentLoaded o Alpine/Livewire hook si prefieres)
function startSwiperBanners() {
    const swiperEl = document.querySelector(".mySwiper-banner");
    const slides = swiperEl?.querySelectorAll(".swiper-slide") ?? [];

    if (!swiperEl || slides.length === 0) return;
    new Swiper(".mySwiper-banner", {
        modules: [Autoplay, Pagination, Navigation],
        loop: slides.length > 1,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        spaceBetween: 20,
        speed: 400,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
}

document.addEventListener("DOMContentLoaded", startSwiperBanners);
document.addEventListener("livewire:navigated", startSwiperBanners);
