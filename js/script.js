function displaySelectedImage(input) {
    // Отримання контейнера для відображення обраного зображення за його ідентифікатором
    let selectedImageContainer = document.getElementById("selected-image-container");

    // Перевірка, чи обрано файли
    if (input.files && input.files[0]) {
        // Отримання обраного зображення за його ідентифікатором
        let selectedImage = document.getElementById("selected-image");

        // Створення об'єкта FileReader для читання вмісту файлу
        let reader = new FileReader();

        // Встановлення обробника подій для завершення читання файлу
        reader.onload = function (e) {
            // Встановлення шляху зображення на основі даних URL
            selectedImage.src = e.target.result;
        };

        // Читання вмісту обраного файлу у форматі Data URL
        reader.readAsDataURL(input.files[0]);

        // Встановлення видимості контейнера для відображення обраного зображення
        selectedImageContainer.style.display = "block";
    } else {
        // Встановлення невидимості контейнера, якщо файли не обрані
        selectedImageContainer.style.display = "none";
    }
}

function validateForm() {
    // Отримання значень поля "name" та файлу зображення
    let name = document.getElementById("name").value;
    let imageInput = document.getElementById("image");
    let image = imageInput.files[0];

    // Перевірка, чи введена назва
    if (name.trim() === "") {
        alert("Будь ласка, заповніть назву.");
        return false;
    }

    // Перевірка, чи обрано зображення
    if (!image) {
        alert("Будь ласка, оберіть фото.");
        return false;
    }

    // Повернення значення true, якщо усі перевірки пройдено успішно
    return true;
}

function validateEditForm() {
    // Отримання значення поля "name" для форми редагування
    let name = document.getElementById("name").value;

    // Перевірка, чи введена назва
    if (name.trim() === "") {
        alert("Будь ласка, заповніть назву.");
        return false;
    }

    // Повернення значення true, якщо усі перевірки пройдено успішно
    return true;
}
