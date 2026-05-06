<?php
/** Sprint 1 – Cart Model */
class Cart {
    public int $user_id;
    public int $product_id;
    public int $quantity;

    public function __construct(int $user_id, int $product_id, int $quantity) {
        $this->user_id    = $user_id;
        $this->product_id = $product_id;
        $this->quantity   = $quantity;
    }
}
