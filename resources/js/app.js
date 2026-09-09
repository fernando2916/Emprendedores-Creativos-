//
import "./assets/string_to_slug";
import "./assets/preview_image";
import "./assets/preview_images";
import "./assets/typewrite";
import "./assets/typewrite-foto";
import "./assets/slider";
import "./assets/slider-servicios";
import "./assets/slider-banner";
import "./assets/slider-testimonio-foto";
import "./quill";

document.addEventListener("livewire:navigated", () => {
    // Volver a inicializar Flowbite después de cada navegación interna
    if (typeof initFlowbite === "function") {
        initFlowbite();
    }
});