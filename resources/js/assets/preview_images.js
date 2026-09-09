window.preview_images = function (event, imgId) {
    const reader = new FileReader();
    reader.onload = function () {
        const output = document.getElementById(imgId);
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
