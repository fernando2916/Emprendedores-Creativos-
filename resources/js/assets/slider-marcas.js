import Swiper from "swiper";
import { Autoplay, FreeMode } from "swiper/modules";

import "swiper/css";

new Swiper(".marcasSwiper", {
    modules: [Autoplay],

    loop: true,

    slidesPerView: 4,
    spaceBetween: 30,

    speed: 6000,

    autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
    },

    allowTouchMove: false,

    // breakpoints: {
    //     640: {
    //         slidesPerView: 3,
    //         // spaceBetween: 40,
    //     },

    //     768: {
    //         slidesPerView: 4,
    //         // spaceBetween: 50,
    //     },

    //     1024: {
    //         slidesPerView: 5,
    //         // spaceBetween: 60,
    //     },

    //     1280: {
    //         slidesPerView: 6,
    //         // spaceBetween: 70,
    //     },
    // },
});
