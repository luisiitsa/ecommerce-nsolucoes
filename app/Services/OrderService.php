<?php

namespace App\Services;

use App\Exports\OrdersExport;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

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
    public function search(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->orderRepository->with('customer')->paginate();
    }

    /**
     * Find method for the Laravel application "E-commerce NSoluções".
     *
     * This method retrieves an order by its unique identifier.
     *
     * @param int $id The unique identifier of the order
     * @return mixed The retrieved order data
     */
    public function find(int $id): mixed
    {
        return $this->orderRepository->find($id);
    }

    /**
     * Export orders method for the Laravel application "E-commerce NSoluções".
     *
     * This method exports orders data in the specified format (excel or pdf).
     * If 'excel' format is requested, it returns an excel file with orders.
     * If 'pdf' format is requested, it returns a pdf file with orders.
     *
     * @param string $format The format in which orders data should be exported ('excel' or 'pdf')
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|false The exported orders file or false if format is invalid
     */
    public function exportOrders($format
    ): \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|false {
        $orders = Order::all();

        if ($format === 'excel') {
            return Excel::download(new OrdersExport, 'orders.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.orders.pdf', compact('orders'));
            return $pdf->download('orders.pdf');
        }

        return false;
    }
}
