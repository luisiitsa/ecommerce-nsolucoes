<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    protected OrderRepository $orderRepository;

    /**
     * Constructor for the Laravel application "E-commerce NSoluções".
     *
     * This method initializes the OrderRepository dependency for the application.
     *
     * @param OrderRepository $orderRepository The OrderRepository instance to be injected
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Search orders method for the Laravel application "E-commerce NSoluções".
     *
     * This method retrieves a paginated list of orders with associated customer information.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator The paginated list of orders with customer details
     */
    public function searchOrders()
    {
        return $this->orderRepository->with('customer')->paginate();
    }
}
