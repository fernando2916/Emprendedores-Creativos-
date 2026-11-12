import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

function startSwiperRelacionados() {
    document
        .querySelectorAll(".productosRelacionadosSwiper")
        .forEach((element) => {
            if (element.swiper) {
                element.swiper.destroy(true, true);
            }

            new Swiper(element, {
                modules: [Navigation, Pagination],

                loop: true,
                slidesPerView: 1,
                spaceBetween: 16,

                preventClicks: false,
                preventClicksPropagation: false,
                touchStartPreventDefault: false,

                speed: 500,
                watchOverflow: true,

                // No limitar la altura del carrusel.
                autoHeight: false,

                // Permitir que las tarjetas tengan su altura natural.
                slidesPerView: "auto",

                navigation: {
                    nextEl: element.querySelector(".relacionados-next"),
                    prevEl: element.querySelector(".relacionados-prev"),
                },

                pagination: {
                    el: element.querySelector(".relacionados-pagination"),
                    clickable: true,
                    dynamicBullets: true,
                },
            });
        });
}

document.addEventListener("DOMContentLoaded", startSwiperRelacionados);
document.addEventListener("livewire:navigated", startSwiperRelacionados);
