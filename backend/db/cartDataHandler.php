<?php

require_once __DIR__ . '/DBaccess.php';
require_once __DIR__ . '/../models/cart.class.php';

class CartDataHandler
{
    private $db;
    public function __construct(dbaccess $dbaccess)
    {
        $this->db = $dbaccess->getConnection();
    }
    public function addToCart(Cart $cart): array
    {
        $stmt = $this->db->prepare("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        quantity = quantity + VALUES(quantity)
    ");
        $stmt->bind_param("iii", $cart->user_id, $cart->product_id, $cart->quantity);
        $stmt->execute();
        $stmt->close();

        $cartCount = $this->getCartCount($cart->user_id);
        return ['cartCount' => $cartCount];
    }

    public function getCartCount(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ($result['total'] ?? 0);
    }

    public function loadCart(int $userId): array
    {
        $stmt = $this->db->prepare("
        SELECT p.id, p.file_path, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN product p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}
