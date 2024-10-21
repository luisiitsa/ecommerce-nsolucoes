<?php

namespace App\Http\Controllers;

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
            $orders = $this->orderService->searchOrders();
            return view('admin.home', compact('orders'));
        }

        return redirect()->route('admin.login');
    }
}
