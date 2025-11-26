<?php

namespace Models;

class Cart extends BaseModel
{
    protected string $table = 'carts';

    /**
     * Get cart items for user with product details
     */
    public function getCartItems($userId)
    {
        $sql = "SELECT c.*, p.name, p.slug, p.price, p.sale_price, p.image, p.stock
                FROM {$this->table} c
                INNER JOIN products p ON c.product_id = p.id
                WHERE c.user_id = :user_id
                ORDER BY c.created_at DESC";

        return $this->getAll($sql, ['user_id' => $userId]);
    }

    /**
     * Add item to cart or update quantity if exists
     */
    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Check if item already exists
        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = :user_id AND product_id = :product_id
                LIMIT 1";

        $existing = $this->getOne($sql, [
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        if ($existing) {
            // Update quantity
            $newQuantity = $existing['quantity'] + $quantity;
            $updateSql = "UPDATE {$this->table}
                         SET quantity = :quantity, updated_at = NOW()
                         WHERE id = :id";

            return $this->execute($updateSql, [
                'quantity' => $newQuantity,
                'id' => $existing['id']
            ]);
        } else {
            // Insert new item
            $insertSql = "INSERT INTO {$this->table}
                         (user_id, product_id, quantity, created_at, updated_at)
                         VALUES (:user_id, :product_id, :quantity, NOW(), NOW())";

            return $this->execute($insertSql, [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateCartQuantity($cartId, $quantity)
    {
        $sql = "UPDATE {$this->table}
                SET quantity = :quantity, updated_at = NOW()
                WHERE id = :id";

        return $this->execute($sql, [
            'quantity' => $quantity,
            'id' => $cartId
        ]);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($cartId)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->execute($sql, ['id' => $cartId]);
    }

    /**
     * Clear all cart items for user
     */
    public function clearCart($userId)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = :user_id";
        return $this->execute($sql, ['user_id' => $userId]);
    }

    /**
     * Get total item count in cart for user
     */
    public function getCartCount($userId)
    {
        $sql = "SELECT SUM(quantity) as total
                FROM {$this->table}
                WHERE user_id = :user_id";

        $result = $this->getOne($sql, ['user_id' => $userId]);
        return $result['total'] ?? 0;
    }

    /**
     * Calculate total price of cart for user
     */
    public function getCartTotal($userId)
    {
        $sql = "SELECT SUM(
                    c.quantity * COALESCE(p.sale_price, p.price)
                ) as total
                FROM {$this->table} c
                INNER JOIN products p ON c.product_id = p.id
                WHERE c.user_id = :user_id";

        $result = $this->getOne($sql, ['user_id' => $userId]);
        return $result['total'] ?? 0;
    }

    /**
     * Get cart item by ID
     */
    public function getCartItemById($cartId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        return $this->getOne($sql, ['id' => $cartId]);
    }

    /**
     * Check if product is in user's cart
     */
    public function isInCart($userId, $productId)
    {
        $sql = "SELECT COUNT(*) as count
                FROM {$this->table}
                WHERE user_id = :user_id AND product_id = :product_id";

        $result = $this->getOne($sql, [
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return $result['count'] > 0;
    }
}
