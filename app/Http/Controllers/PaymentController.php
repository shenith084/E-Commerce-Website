<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayhereService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PayhereService $payhere) {}

    public function pay(Order $order)
    {
        // Make sure the order belongs to the logged-in user
        abort_if($order->user_id !== auth()->id(), 403);

        $paymentData = $this->payhere->buildPaymentData($order);

        return view('payment.payhere_form', [
            'paymentData' => $paymentData,
            'paymentUrl'  => $this->payhere->getPaymentUrl(),
        ]);
    }

    public function notify(Request $request)
    {
        $data = $request->all();

        if (!$this->payhere->verifyNotification($data)) {
            return response('Invalid hash', 400);
        }

        $order = Order::where('order_number', $data['order_id'])->first();
        if (!$order) {
            return response('Order not found', 404);
        }

        // status_code 2 = Success
        if ((int) $data['status_code'] === 2) {
            $order->update([
                'payment_status'   => 'paid',
                'status'           => 'processing',
                'payhere_order_id' => $data['payment_id'] ?? null,
            ]);

            // Clear cart
            session()->forget('cart');
        } elseif ((int) $data['status_code'] === 0) {
            $order->update(['payment_status' => 'pending']);
        } else {
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        }

        return response('OK', 200);
    }

    public function return(Request $request)
    {
        $orderId = session()->get('pending_order_id');
        $order   = $orderId ? Order::find($orderId) : null;
        session()->forget(['cart', 'pending_order_id']);

        return view('payment.success', compact('order'));
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
