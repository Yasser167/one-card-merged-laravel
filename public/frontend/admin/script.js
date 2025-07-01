function disableButton() {
    let allFormButtons = document.querySelectorAll("button");

    if (allFormButtons) {
        allFormButtons.forEach((allFormButton) => {
            allFormButton.disabled = true;
        });
    }

    return true;
}

document.addEventListener("DOMContentLoaded", function () {
    let imageFiles = document.querySelectorAll(".image-file");

    if (imageFiles) {
        imageFiles.forEach((imageFile) => {
            imageFile.addEventListener("change", function (event) {
                const file = event.target.files[0];

                const preview = imageFile.parentNode.querySelector(".preview");

                if (file) {
                    const objectURL = URL.createObjectURL(file);
                    preview.src = objectURL;
                } else {
                    preview.src = "";
                }
            });
        });
    }

    const navbarActives = document.querySelectorAll(".navbar .navbar-nav a");
    if (navbarActives) {
        navbarActives.forEach((navbarActive) => {
            if (navbarActive.href == window.location.href) {
                navbarActive.classList.add("active");
            } else {
                navbarActive.classList.remove("active");
            }
        });
    }

    const clickEyes = document.querySelectorAll(".click_eye");

    if (clickEyes) {
        clickEyes.forEach((item) => {
            item.addEventListener("click", function () {
                const inputGroup = this.closest(".input-group");
                const passwordInput = inputGroup.querySelector(
                    "input[type='password'], input[type='text']"
                );
                const eye = inputGroup.querySelector(".eye");
                const eyeOff = inputGroup.querySelector(".eye-off");

                if (passwordInput) {
                    const type =
                        passwordInput.getAttribute("type") === "password"
                            ? "text"
                            : "password";
                    passwordInput.setAttribute("type", type);

                    if (type === "password") {
                        eye.style.display = "inline";
                        eyeOff.style.display = "none";
                    } else {
                        eye.style.display = "none";
                        eyeOff.style.display = "inline";
                    }
                }
            });
        });
    }

    const addItemAdmins = document.querySelectorAll(".add_item_admin");

    if (addItemAdmins) {
        addItemAdmins.forEach((addItemAdmin) => {
            const form = addItemAdmin.nextElementSibling;
            form.style.display = "none";

            addItemAdmin.addEventListener("click", function () {
                if (form) {
                    form.style.display =
                        form.style.display === "none" ? "block" : "none";
                }
            });
        });
    }

    const linksSeo = document.querySelectorAll(".link_seo");

    if (linksSeo) {
        linksSeo.forEach((linkSeo) => {
            linkSeo.addEventListener("input", function () {
                var value = this.value;
                var newValue = value.toLowerCase().replace(/\s+/g, "-");
                this.value = newValue;
            });
        });
    }
});

var alerts = document.querySelectorAll(".alert");

if (alerts) {
    alerts.forEach(function (alert) {
        setTimeout(function () {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 3000);
    });
}

$(document).ready(function () {
    $(".description_en").summernote({
        placeholder: "description en",
        tabsize: 2,
        height: 400,
        width: "100%",
        toolbar: [
            ["style", ["style"]],
            ["color", ["color"]],
            ["insert", ["link", "video"]],
            ["view", ["codeview"]],
        ],
    });

    $(".description_ar").summernote({
        placeholder: "description ar",
        tabsize: 2,
        height: 400,
        width: "100%",
        toolbar: [
            ["style", ["style"]],
            ["color", ["color"]],
            ["insert", ["link", "video"]],
            ["view", ["codeview"]],
        ],
    });

    $(".multiple_images").on("change", function () {
        var previewContainer = $(this)
            .closest(".form-group")
            .find(".image-preview");
        previewContainer.empty();
        var files = this.files;

        if (files.length > 0) {
            $.each(files, function (index, file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    previewContainer.append(
                        '<div><img src="' +
                            e.target.result +
                            '" alt="Image"></div>'
                    );
                };
                reader.readAsDataURL(file);
            });
        }
    });

    $(".multiple_images_edit").on("change", function () {
        var previewContainer = $(this)
            .closest(".form-group")
            .find(".image-preview_edit");
        var files = this.files;

        if (files.length > 0) {
            $.each(files, function (index, file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    previewContainer.append(
                        '<div><img src="' +
                            e.target.result +
                            '" alt="Image"></div>'
                    );
                };
                reader.readAsDataURL(file);
            });
        }
    });

    $('input[name="delete_images[]"]').change(function () {
        if ($(this).is(":checked")) {
            $(this).closest(".existing-image").fadeOut(500);
        }
    });
});
