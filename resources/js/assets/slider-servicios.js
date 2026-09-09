import Swiper from "swiper";
import { Pagination, Autoplay } from "swiper/modules";
/* Swiper */
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/autoplay";

// Inicializa Swiper (puedes mover esto al DOMContentLoaded o Alpine/Livewire hook si prefieres)
function startSwiperServicios() {
    new Swiper(".mySwiper-slider", {
        modules: [Autoplay, Pagination],
        loop: true,
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
    });
}

document.addEventListener("DOMContentLoaded", startSwiperServicios);
document.addEventListener("livewire:navigated", startSwiperServicios);
