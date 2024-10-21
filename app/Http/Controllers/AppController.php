<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class AppController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function home(
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $products = $this->productService->list();

        return view('app.home', ['products' => $products]);
    }
}
