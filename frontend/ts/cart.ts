interface Cart {
  id: number;
  file_path: string;
  name: string;
  price: number;
  quantity: number;
}

$(function () {
  // Demo-userId: In production wird dieser Wert nach Login gesetzt
  let userId: number = 1;

  $(document).on("click", ".button-addToCartList", function (event) {
    event.preventDefault();
    const productId = $(this).data("id") as number;
    addToCart(userId, productId, 1);
  });

  $(document).on("click", "#loadCartBtn", function (event) {
    event.preventDefault();
    loadCart(userId);
  });

  function addToCart(userId: number, productId: number, quantity: number): void {
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
      error: function (xhr: JQuery.jqXHR) {
        const res = xhr.responseJSON || { error: "Unbekannter Fehler" };
        alert("Fehler: " + res.error);
      },
    });
  }

  function loadCart(userId: number): void {
    $.ajax({
      type: "POST",
      url: "../../backend/serviceHandler.php?handler=cart&method=loadCart",
      contentType: "application/json",
      dataType: "json",
      data: JSON.stringify({ userId: userId }),
      success: function (response: Cart[]) {
        const $cartOutput = $("#cartOutput");
        $cartOutput.empty();
        if (response.length === 0) {
          $cartOutput.append('<li class="list-group-item">Warenkorb ist leer</li>');
        } else {
          response.forEach((item) => {
            $cartOutput.append(
              `<li class="list-group-item">${item.name} (${item.quantity})</li>`,
            );
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
