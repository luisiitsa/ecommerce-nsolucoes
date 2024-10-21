<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    public function store(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $customer = auth('customer')->user();
        $cart = session()->get('cart', []);
        $paymentValue = $request->input('payment');
        $freight = $request->input('freight');
        $paymentMethod = $request->input('paymentMethod');

        if (empty($cart)) {
            return response()->json(['message' => 'Carrinho vazio'], 400);
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'total' => $paymentValue,
            'freight' => $freight,
            'status' => 'pending',
            'type_payment' => $paymentMethod
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        $asaasData = [
            'billingType' => $paymentMethod,
            'customer' => $customer->asaas_id,
            'value' => $paymentValue,
            'dueDate' => now()->addDays(5)->format('Y-m-d'),
            'postalService' => false
        ];

        if ($paymentMethod === 'CREDIT_CARD') {
            $asaasData['creditCard'] = $request->input('creditCard');
            $asaasData['creditCardHolderInfo'] = [
                'name' => $customer->name,
                'email' => $customer->email,
                'cpfCnpj' => $customer->cpf,
                'postalCode' => $customer->postal_code,
                'addressNumber' => $customer->number,
                'phone' => $customer->cellphone
            ];
            $asaasData['authorizeOnly'] = false;
            $asaasData['remoteIp'] = $request->ip();
        }

        $asaasResponse = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'access_token' => env('ASAAS_SECRET_ACCESS_KEY')
        ])->post(env('ASAAS_HOST') . 'payments', $asaasData);

        if ($asaasResponse->successful()) {
            session()->forget('cart');

            return redirect()->route('app.home');
        } else {
            $order->delete();

            return response()->json([
                'message' => 'Erro ao processar pagamento',
                'error' => $asaasResponse->json()
            ], 500);
        }
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
