<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Session;

class CartRepository
{
    public function addToCart($productId, $productData): void
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $productData['product_name'],
                'price' => $productData['product_price'],
                'weight' => $productData['product_weight'] ?? '',
                'length' => $productData['product_length'] ?? '',
                'height' => $productData['product_height'] ?? '',
                'width' => $productData['product_width'] ?? '',
                'quantity' => 1
            ];
        }

        $this->saveCart($cart);
    }

    public function getCart()
    {
        return Session::get('cart', []);
    }

    public function saveCart($cart): void
    {
        Session::put('cart', $cart);
    }

    public function removeFromCart($productId): void
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
        }
    }
}
