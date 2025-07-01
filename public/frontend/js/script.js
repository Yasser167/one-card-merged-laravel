function disableButton() {
    let allFormButtons = document.querySelectorAll("button");

    if (allFormButtons) {
        allFormButtons.forEach((allFormButton) => {
            allFormButton.disabled = true;
        });
    }

    return true;
}

function alertsHide() {
    let alerts = document.querySelectorAll(".alert");

    if (alerts) {
        alerts.forEach(function (alert) {
            setTimeout(function () {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });
    }
}

function updateTotal() {
    let productData = [];
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    cart.forEach((item) => {
        productData.push({
            price: parseFloat(item.price),
            quantity: parseInt(item.quantity),
        });
    });

    let total = productData.reduce(
        (acc, item) => acc + item.price * item.quantity,
        0
    );

    $(".total").text(total.toFixed(2));

    $("#cart_items").val(JSON.stringify(cart));

    $(".basket_cart span").text(cart.length);
}

function displayCart() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartBody = $(".cart-body");

    cartBody.empty();

    if (cart.length === 0) {
        $(".offcanvas-footer").hide();
        cartBody.append(
            `<tr><td colspan="5" class="text-center">${no_items_in_cart}</td></tr>`
        );
        return;
    }

    cart.forEach(function (item, index) {
        $.ajax({
            url: `/product-cart/${item.id}`,
            type: "GET",
            success: function (response) {
                if (response && (response.name_en || response.name_ar)) {
                    let product = response;

                    let dirBody = $("body").attr("dir");
                    let language = dirBody;

                    let originUrl = window.location.origin;
                    let productName =
                        language === "ar" ? product.name_ar : product.name_en;

                    let truncatedName =
                        productName.length > 10
                            ? productName.substring(0, 10) + "..."
                            : productName;

                    let productImage =
                        product.images && product.images.length > 0
                            ? product.images[0].img
                            : originUrl + "/frontend/images/img_upload.webp";

                    let row = $(`
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>
                                <div>
                                <img src="${originUrl}/storage/${productImage}" alt="${truncatedName}" style="border-radius: 50%;width: 50px; height: 50px; object-fit: cover;" />
                                </div>
                                ${truncatedName}
                            </td>
                            <td class="d-flex flex-column align-items-center data_quantities">
                                <p class="btn btn-danger"><span class="product-price">${
                                    product.price
                                }</span> ${currencySymbol}</p>
                                <div class="input-group" style="width: 120px;" dir="ltr">
                                    <button class="btn btn-outline-secondary btn-decrease" type="button" onclick="updateQuantity(this, ${
                                        product.id
                                    }, -1)">-</button>
                                    <input type="text" class="form-control text-center product-quantity" value="${
                                        item.quantity
                                    }" min="1" readonly>
                                    <button class="btn btn-outline-secondary btn-increase" type="button" onclick="updateQuantity(this, ${
                                        product.id
                                    }, 1)">+</button>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="removeFromCart(${
                                    product.id
                                })"><i class="bi bi-x"></i></button>
                            </td>
                        </tr>
                    `);

                    cartBody.append(row);
                    $(".offcanvas-footer").show();
                    updateTotal();
                } else {
                    console.error(
                        "Product data is missing or incomplete:",
                        response
                    );
                }
            },
            error: function (xhr) {
                if (xhr.status === 404) {
                    console.log("Product not found." + error);
                } else {
                    alert("An error occurred.");
                    console.log("Product not found." + error);
                }
            },
        });
    });

    let cart_product_id = $(".add_to_cart_product_id").val();
    let cart_product_quantity = $(".all_product .product-quantity");

    let existingProductIndex = cart.findIndex(
        (product) => product.id == cart_product_id
    );

    if (existingProductIndex > -1) {
        cart_product_quantity.val(cart[existingProductIndex].quantity);
    }
}

function updateQuantity(button, id, change) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let existingProductIndex = cart.findIndex((item) => item.id == id);

    cart[existingProductIndex].quantity =
        parseInt(cart[existingProductIndex].quantity) + change;

    if (cart[existingProductIndex].quantity < 1) {
        cart[existingProductIndex].quantity = 1;
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    let parent = $(button).closest(".input-group");
    let quantityInput = parent.find(".product-quantity");

    quantityInput.val(cart[existingProductIndex].quantity);

    updateTotal();
}

function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let updatedCart = cart.filter(function (item) {
        return item.id != id;
    });

    localStorage.setItem("cart", JSON.stringify(updatedCart));

    displayCart();
    updateTotal();
}

function addToCart(button, id) {
    $(button).prop("disabled", true);

    let productName = $(button)
        .closest(".col-md-5")
        .find(".product-title")
        .text();

    let selectedSize = $(button)
        .closest(".col-md-5")
        .find('input[name="size"]:checked')
        .val();

    let productPrice = $(button)
        .closest(".col-md-5")
        .find(".text-danger span")
        .text();

    let productQuantity = $(button)
        .closest(".col-md-5")
        .find(".product-quantity")
        .val();

    let productData = {
        id: id,
        name: productName,
        size: selectedSize,
        price: productPrice,
        quantity: productQuantity,
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let existingProductIndex = cart.findIndex((item) => item.id === id);

    if (existingProductIndex > -1) {
        cart[existingProductIndex].quantity = productQuantity;
        cart[existingProductIndex].size = selectedSize;

        const htmlFailure = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>${product_is_in_the_cart}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;

        document.body.insertAdjacentHTML("beforeend", htmlFailure);
    } else {
        cart.push(productData);

        const htmlFailure = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <small>${product_has_been_added_to_cart}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;

        document.body.insertAdjacentHTML("beforeend", htmlFailure);
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    displayCart();
    updateTotal();
    alertsHide();

    setTimeout(() => {
        $(button).prop("disabled", false);
    }, 3000);
}

$(document).ready(function () {
    let timeSpeedSlider = 3000;
    $(".slider_home").slick({
        slidesToShow: 4,
        arrows: true,
        autoplay: true,
        autoplaySpeed: timeSpeedSlider,
        dots: true,
        loop: true,
        pauseOnHover: true,

        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow: 1,
                },
            },
        ],
    });

    $(".main-slider").slick({
        slidesToShow: 1,
        arrows: false,
        fade: true,
        asNavFor: ".thumbnail-slider",
        pauseOnHover: true,
    });

    $(".thumbnail-slider").slick({
        slidesToShow: 3,
        asNavFor: ".main-slider",
        dots: true,
        focusOnSelect: true,
        autoplay: true,
        autoplaySpeed: timeSpeedSlider,
        pauseOnHover: true,
    });

    $(".thumbnail-slider").on(
        "afterChange",
        function (event, slick, currentSlide) {
            $(".thumbnail-slider .slick-slide").removeClass("slick-active");
            $(".thumbnail-slider .slick-slide")
                .eq(currentSlide)
                .addClass("slick-active");
        }
    );

    $(".all_product .update_increase").on("click", function () {
        let quantityInput = $(this).siblings(".product-quantity");
        let quantity = parseInt(quantityInput.val());
        quantityInput.val(quantity + 1);
    });

    $(".all_product .update_decrease").on("click", function () {
        let quantityInput = $(this).siblings(".product-quantity");
        let quantity = parseInt(quantityInput.val());
        if (quantity > 1) {
            quantityInput.val(quantity - 1);
        }
    });

    $(".product-quantity").on("change", function () {
        let quantity = parseInt($(this).val());
        if (isNaN(quantity) || quantity < 1) {
            $(this).val(1);
            quantity = 1;
        }
        updateTotal();
    });

    $('.size-option input[type="radio"]').on("change", function () {
        $(".size-option").removeClass("active");

        $(this).parent().addClass("active");
    });

    $('.size-option input[type="radio"]:checked').parent().addClass("active");

    let selectedSizeOption = $('.size-option input[type="radio"]:checked');

    if (selectedSizeOption.length === 0) {
        let firstSizeOption = $('.size-option input[type="radio"]').first();
        firstSizeOption.prop("checked", true);
        firstSizeOption.closest(".size-option").addClass("active");
    }

    displayCart();
    updateTotal();
    alertsHide();
});
