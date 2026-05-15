<?php
require_once __DIR__ . '/../models/cart.class.php';

class CartHandler
{
    private $dataHandler;
    public function __construct($cartDataHandler)
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
            return ['code' => 401];
        }

        switch ($method) {
            case "addToCart":
                if (!$productId || !$quantity) {
                    return ['code' => 400];
                }
                $cart = new Cart($userId, $productId, $quantity);
                return $this->dataHandler->addToCart($cart);

            case "loadCart":
                return $this->dataHandler->loadCart($userId);

            default:
                return ['code' => 400];
        }
    }
}
