<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected OrderService $orderService;

    /**
     * Initializes a new instance of the E-commerce NSoluções application.
     *
     * @param OrderService $orderService The order service used by the application.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display the dashboard for the admin users or redirect to the login page if not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse {
        if (Auth::check()) {
            $orders = $this->orderService->search();
            return view('admin.home', compact('orders'));
        }

        return redirect()->route('admin.login');
    }

    /**
     * Display the specified order.
     *
     * @param Order $order The order to be displayed.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application The view for showing the order.
     */
    public function show(Order $order
    ): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Export data from the application in the specified format.
     *
     * @param string $format The format in which data should be exported
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function export($format
    ): \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse {
        $export = $this->orderService->exportOrders($format);

        if ($export) {
            return $export;
        }

        return back()->with('error', 'Formato de exportação inválido');
    }
}
