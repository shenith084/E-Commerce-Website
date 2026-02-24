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
        // Check if the authenticated user owns this order
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

        // Handle successful payment
        if ((int) $data['status_code'] === 2) {
            $order->update([
                'payment_status'   => 'paid',
                'status'           => 'processing',
                'payhere_order_id' => $data['payment_id'] ?? null,
            ]);

            // Clear the shopping cart session
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
        
        // Keep the order ID in session for local testing so we can show the confirmation button
        if (!(config('app.env') === 'local' && $order && $order->payment_status === 'pending')) {
            session()->forget(['cart', 'pending_order_id']);
        }

        return view('payment.success', compact('order'));
    }

    public function cancel()
    {
        return view('payment.cancel');
    }

    // Development testing routes

    public function testPage(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        return view('payment.test_payment', compact('order'));
    }

    public function testProcess(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $action = $request->input('action', 'success');

        if ($action === 'success') {
            $order->update([
                'payment_status'   => 'paid',
                'status'           => 'processing',
                'payhere_order_id' => 'TEST-' . strtoupper(uniqid()),
            ]);
            
            // Keep session data for local environment to display the updated order status
            if (config('app.env') !== 'local') {
                session()->forget(['cart', 'pending_order_id']);
            }
            
            // Redirect user to selected page
            $redirectTo = $request->input('redirect', 'payment.return');
            
            return redirect()->route($redirectTo)
                ->with('success', 'Payment confirmed manually! Order is now processing.');
        }

        // Handle cancelled or failed test payment
        $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        session()->forget(['cart', 'pending_order_id']);
        return redirect()->route('payment.cancel')
            ->with('error', 'Test payment was cancelled.');
    }
}
