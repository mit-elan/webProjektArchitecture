"use strict";
$(function () {
    // Demo-userId: In production wird dieser Wert nach Login gesetzt
    let userId = 1;
    $(document).on("click", ".button-addToCartList", function (event) {
        event.preventDefault();
        const productId = $(this).data("id");
        addToCart(userId, productId, 1);
    });
    $(document).on("click", "#loadCartBtn", function (event) {
        event.preventDefault();
        loadCart(userId);
    });
    function addToCart(userId, productId, quantity) {
        $.ajax({
            type: "POST",
            url: "../../backend/serviceHandler.php?handler=cart&method=addToCart",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ userId, productId, quantity }),
            success: function (response) {
                $("#cart-count").text(response.cartCount);
                alert("Produkt hinzugefügt! Artikel im Warenkorb: " + response.cartCount);
            },
            error: function (xhr) {
                const res = xhr.responseJSON || { error: "Unbekannter Fehler" };
                alert("Fehler: " + res.error);
            },
        });
    }
    function loadCart(userId) {
        $.ajax({
            type: "POST",
            url: "../../backend/serviceHandler.php?handler=cart&method=loadCart",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({ userId: userId }),
            success: function (response) {
                const $cartOutput = $("#cartOutput");
                $cartOutput.empty();
                if (response.length === 0) {
                    $cartOutput.append('<li class="list-group-item">Warenkorb ist leer</li>');
                }
                else {
                    response.forEach((item) => {
                        $cartOutput.append(`<li class="list-group-item">${item.name} (${item.quantity})</li>`);
                    });
                }
            },
            error: function (xhr) {
                const res = xhr.responseJSON || { error: "Unbekannter Fehler" };
                alert("Fehler: " + res.error);
            },
        });
    }
});
