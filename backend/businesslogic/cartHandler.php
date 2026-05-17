<?php
require_once __DIR__ . '/../models/cart.class.php';

class CartHandler
{
    private CartDataHandler $dataHandler;
    public function __construct(CartDataHandler $cartDataHandler)
    {
        $this->dataHandler = $cartDataHandler;
    }

    public function handle(string $method, array $data): ?array
    {
        // Validierung
        $userId    = $data['userId']    ?? null;
        $productId = $data['productId'] ?? null;
        $quantity  = $data['quantity']  ?? null;

        if (!$userId) {
            return ['code' => 401, 'error' => 'Benutzer nicht angemeldet'];
        }

        switch ($method) {
            case "addToCart":
                if (!$productId || !$quantity) {
                    return ['code' => 400, 'error' => 'productId und quantity sind erforderlich'];
                }
                $cart = new Cart($userId, $productId, $quantity);
                return $this->dataHandler->addToCart($cart);

            case "loadCart":
                return $this->dataHandler->loadCart($userId);

            default:
                return ['code' => 400, 'error' => 'Unbekannte Methode: ' . $method];
        }
    }
}
