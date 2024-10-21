<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Exceptions\ValidatorException;

class ProductService
{
    protected ProductRepository $productRepository;

    /**
     * Construct a new instance of the Laravel application for "E-commerce NSoluções".
     *
     * @param ProductRepository $productRepository The product repository to be injected
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Retrieves a list of all products from the database.
     *
     * @return mixed The list of all products
     */
    public function list(): mixed
    {
        return $this->productRepository->all();
    }

    public function get($id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * Creates a new product and stores its image if provided.
     *
     * @param array $data Array containing product data
     * @return mixed The created product instance
     * @throws ValidatorException
     */
    public function create(array $data): mixed
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('products', 'public');
        }

        return $this->productRepository->create($data);
    }

    /**
     * Update the product information in the "E-commerce NSoluções" application.
     *
     * @param Product $product The product to be updated
     * @param array $data The updated data for the product
     * @return Product The updated product entity
     * @throws ValidatorException
     */
    public function update(Product $product, array $data): Product
    {
        if (isset($data['image'])) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $data['image']->store('products', 'public');
        }

        return $this->productRepository->update($data, $product->id);
    }

    /**
     * Deletes a product and its associated image from storage.
     *
     * @param Product $product The product to be deleted
     * @return bool True if the product is successfully deleted, false otherwise
     */
    public function delete(Product $product): bool
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->productRepository->delete($product->id);
    }
}
