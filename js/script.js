
    function displaySelectedImage(input) {
    let selectedImageContainer = document.getElementById("selected-image-container");

    if (input.files && input.files[0]) {
    let selectedImage = document.getElementById("selected-image");
    let reader = new FileReader();
    reader.onload = function (e) {
    selectedImage.src = e.target.result;
};
    reader.readAsDataURL(input.files[0]);

    selectedImageContainer.style.display = "block";
} else {
    selectedImageContainer.style.display = "none";
}
}

    function validateForm() {
    let name = document.getElementById("name").value;
    let imageInput = document.getElementById("image");
    let image = imageInput.files[0];

    if (name.trim() === "") {
    alert("Будь ласка, заповніть назву.");
    return false;
}
    if (!image) {
    alert("Будь ласка, оберіть фото.");
    return false;
}
    return true;
}

    function validateEditForm() {
        let name = document.getElementById("name").value;

        if (name.trim() === "") {
            alert("Будь ласка, заповніть назву.");
            return false;
        }
        return true;
    }
