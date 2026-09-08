import Quill from "quill";

document.addEventListener("DOMContentLoaded", () => {
    const editorContainer = document.getElementById("editor");

    if (editorContainer) {
        const quill = new Quill("#editor", {
            theme: "snow", // o 'bubble'
            placeholder: "Escribe aquí...",
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],
                    ["bold", "italic", "underline", "strike"],
                    [{ color: [] }, { background: [] }],
                    [
                        { list: "ordered" },
                        { list: "bullet" },
                        { list: "check" },
                    ],
                    ["blockquote", "code-block"],
                    ["image", "link"],
                ],
            },
        });

        // Ejemplo para sincronizar el contenido con un input hidden
        const hiddenInput = document.getElementById("contenido");
        quill.on("text-change", () => {
            hiddenInput.value = quill.root.innerHTML;
        });
    }
});
