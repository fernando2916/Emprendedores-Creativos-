import Swiper from "swiper";
import { Navigation, Thumbs } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("livewire:navigated", () => {
    const thumbsElement = document.querySelector(".productoThumbsSwiper");
    const principalElement = document.querySelector(".productoPrincipalSwiper");

    // No hacer nada si la galería no existe
    if (!principalElement) {
        return;
    }

    let thumbsSwiper = null;

    /*
    |--------------------------------------------------------------------------
    | Swiper de miniaturas
    |--------------------------------------------------------------------------
    */

    if (thumbsElement) {
        thumbsSwiper = new Swiper(thumbsElement, {
            modules: [Thumbs],

            spaceBetween: 10,

            slidesPerView: 4,

            watchSlidesProgress: true,

            breakpoints: {
                640: {
                    slidesPerView: 5,
                },

                1024: {
                    slidesPerView: 5,
                },
            },
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Swiper principal
    |--------------------------------------------------------------------------
    */

    new Swiper(principalElement, {
        modules: [Navigation, Thumbs],

        spaceBetween: 10,

        slidesPerView: 1,

        navigation: {
            nextEl: ".productoPrincipalSwiper .swiper-button-next",
            prevEl: ".productoPrincipalSwiper .swiper-button-prev",
        },

        thumbs: thumbsSwiper
            ? {
                  swiper: thumbsSwiper,
              }
            : undefined,
    });
});
