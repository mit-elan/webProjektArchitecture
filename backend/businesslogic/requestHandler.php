<?php
require_once __DIR__ . '/../db/cartDataHandler.php';
require_once __DIR__ . '/cartHandler.php';

class RequestHandler {
    private CartHandler    $cartHandler;
   // private UserHandler    $userHandler;
   // private ProductHandler $productHandler;

    public function __construct(DBaccess $db) {
        // Jeder Handler bekommt seinen eigenen DataHandler mit dbaccess
        $this->cartHandler    = new CartHandler(new CartDataHandler($db));
     //   $this->userHandler    = new UserHandler(new UserDataHandler($db));
      //  $this->productHandler = new ProductHandler(new ProductDataHandler($db));
    }

    public function dispatch(string $handler, string $method, array $data): ?array {
        return match($handler) {
            'cart'     => $this->cartHandler->handle($method, $data),
         //   'users'    => $this->userHandler->handle($method, $data),
         //   'products' => $this->productHandler->handle($method, $data),
            default    => null,
        };
    }
}
?>