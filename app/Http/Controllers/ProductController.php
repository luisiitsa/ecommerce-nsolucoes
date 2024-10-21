<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;

    /**
     * Constructor for the E-commerce NSoluções application.
     *
     * @param \App\Services\ProductService $productService The product service instance
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display the index page for products.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application The view or view factory for the product index page
     */
    public function index(
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $products = $this->productService->list();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Store a new product in the database.
     *
     * @param \App\Http\Requests\CreateProductRequest $request The incoming request data
     * @return \Illuminate\Http\RedirectResponse A redirect response to the product index page
     */
    public function store(CreateProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->productService->create($request->validated());
        return redirect()->route('admin.products.index');
    }

    /**
     * Show the create product form.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application The view instance for the product creation form
     */
    public function create(
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.products.create');
    }

    /**
     * Edit a product.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
     */
    public function edit(Product $product
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Updates a product in the E-commerce NSoluções application.
     *
     * @param UpdateProductRequest $request The request containing the updated product data.
     * @param Product $product The product to be updated.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the 'admin.products.index' route.
     */
    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $this->productService->update($product, $request->validated());
        return redirect()->route('admin.products.index');
    }

    /**
     * Deletes a product and redirects to the admin products index page.
     *
     * @param Product $product The product to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $this->productService->delete($product);
        return redirect()->route('admin.products.index');
    }
}
