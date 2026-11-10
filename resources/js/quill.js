import Quill from "quill";

function inicializarQuill() {
    /*
    |--------------------------------------------------------------------------
    | Editor existente
    |--------------------------------------------------------------------------
    */

    const editorContainer = document.getElementById("editor");

    if (
        editorContainer &&
        !editorContainer.classList.contains("ql-container")
    ) {
        const quill = new Quill("#editor", {
            theme: "snow",

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

        const hiddenInput = document.getElementById("contenido");

        quill.on("text-change", () => {
            if (hiddenInput) {
                hiddenInput.value = quill.root.innerHTML;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Editor de producto
    |--------------------------------------------------------------------------
    */

    const productoEditor = document.getElementById("editor-producto");

    if (productoEditor && !productoEditor.classList.contains("ql-container")) {
        const quillProducto = new Quill("#editor-producto", {
            theme: "snow",

            placeholder: "Escribe la descripción del producto...",

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

        /*
        |--------------------------------------------------------------------------
        | Cargar descripción existente
        |--------------------------------------------------------------------------
        */

        const descripcion = productoEditor.dataset.descripcion;

        if (descripcion) {
            quillProducto.root.innerHTML = descripcion;
        }

        /*
        |--------------------------------------------------------------------------
        | Campo oculto
        |--------------------------------------------------------------------------
        */

        const hiddenInput = document.getElementById("descripcion-producto");

        /*
        |--------------------------------------------------------------------------
        | Sincronizar Quill → Livewire
        |--------------------------------------------------------------------------
        */

        quillProducto.on("text-change", () => {
            if (!hiddenInput) {
                return;
            }

            hiddenInput.value = quillProducto.root.innerHTML;

            hiddenInput.dispatchEvent(
                new Event("input", {
                    bubbles: true,
                }),
            );
        });
    }
}

document.addEventListener("DOMContentLoaded", inicializarQuill);

document.addEventListener("livewire:navigated", inicializarQuill);

const hiddenInput = document.getElementById("descripcion-producto");

