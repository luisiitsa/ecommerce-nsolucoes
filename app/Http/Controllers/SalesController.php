<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;

class SalesController extends Controller
{
    protected ProductService $productService;

    /**
     * Constructor for the Laravel application "E-commerce NSoluções".
     *
     * @param ProductService $productService The product service instance to be injected
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display the specified product on the Laravel application "E-commerce NSoluções".
     *
     * @param Product $product The product instance to be displayed
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application The view for the specified product
     */
    public function show(Product $product
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application {
        $product = $this->productService->get($product->id);
        return view('app.sale', compact('product'));
    }
}
