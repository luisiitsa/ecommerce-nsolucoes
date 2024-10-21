<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function showCart(
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $cart = $this->cartService->getCart();
        return view('app.cart', compact('cart'));
    }

    public function addToCart(Request $request): \Illuminate\Http\RedirectResponse
    {
        $productData = $request->only(
            ['product_name', 'product_price', 'product_weight', 'product_length', 'product_height', 'product_width']
        );
        $productId = $request->input('product_id');

        $this->cartService->addProductToCart($productId, $productData);

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function processSale(Request $request
    ): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $productData = $request->only(
            ['product_name', 'product_price', 'product_weight', 'product_length', 'product_height', 'product_width']
        );
        $productId = $request->input('product_id');

        $this->cartService->processSale($productId, $productData);

        return redirect(route('app.cart'))->with('success', 'Venda processada com sucesso!');
    }

    public function removeFromCart(Request $request): \Illuminate\Http\RedirectResponse
    {
        $productId = $request->input('product_id');
        $this->cartService->removeProductFromCart($productId);

        return redirect()->back()->with('success', 'Produto removido do carrinho!');
    }
}
