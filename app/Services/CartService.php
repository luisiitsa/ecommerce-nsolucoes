<?php

namespace App\Services;

use App\Repositories\CartRepository;

class CartService
{
    protected CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addProductToCart($productId, $productData): void
    {
        $this->cartRepository->addToCart($productId, $productData);
    }

    public function removeProductFromCart($productId): void
    {
        $this->cartRepository->removeFromCart($productId);
    }

    public function getCart()
    {
        return $this->cartRepository->getCart();
    }

    public function processSale($productId, $productData): void
    {
        $this->cartRepository->addToCart($productId, $productData);
    }
}
