import Swiper from "swiper";
import { Pagination, Autoplay } from "swiper/modules";
/* Swiper */
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/autoplay";

// Inicializa Swiper (puedes mover esto al DOMContentLoaded o Alpine/Livewire hook si prefieres)
function startSwiperDiseño() {
    const swiperEl = document.querySelector(".mySwiper");
    const slides = swiperEl?.querySelectorAll(".swiper-slide") ?? [];

    if (!swiperEl || slides.length === 0) return;

    new Swiper(".mySwiper", {
        modules: [Autoplay, Pagination],
        loop: slides.length > 1,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        spaceBetween: 10,
        speed: 400,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
}

document.addEventListener("DOMContentLoaded", startSwiperDiseño);
document.addEventListener("livewire:navigated", startSwiperDiseño);
