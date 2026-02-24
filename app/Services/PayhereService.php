<?php

namespace App\Services;

class PayhereService
{
    protected string $merchantId;
    protected string $merchantSecret;
    protected string $mode;

    public function __construct()
    {
        $this->merchantId     = config('services.payhere.merchant_id');
        $this->merchantSecret = config('services.payhere.secret');
        $this->mode           = config('services.payhere.mode', 'sandbox');
    }

    public function getPaymentUrl(): string
    {
        return $this->mode === 'sandbox'
            ? 'https://sandbox.payhere.lk/pay/checkout'
            : 'https://www.payhere.lk/pay/checkout';
    }

    public function generateHash(string $orderId, float $amount, string $currency = 'LKR'): string
    {
        $merchantId      = trim($this->merchantId);
        $merchantSecret  = trim($this->merchantSecret);
        
        // Payhere expects amount formatted to 2 decimal places without thousands separator
        $amountFormatted = number_format($amount, 2, '.', '');
        
        // The Secret must be MD5 hashed and Uppercased first
        $hashedSecret = strtoupper(md5($merchantSecret));
        
        // Assembly string: MerchantID + OrderID + Amount + Currency + HashedSecret
        $hashString = $merchantId . $orderId . $amountFormatted . $currency . $hashedSecret;
        $hash = strtoupper(md5($hashString));

        // Critical Diagnostic Logging
        \Log::debug('Payhere Hash Diagnostic', [
            'merchant_id'    => $merchantId,
            'order_id'       => $orderId,
            'amount'         => $amountFormatted,
            'currency'       => $currency,
            'secret_masked'  => substr($merchantSecret, 0, 4) . '...' . substr($merchantSecret, -4),
            'hashed_secret'  => $hashedSecret,
            'hash_string'    => $hashString,
            'final_hash'     => $hash
        ]);

        return $hash;
    }


    public function buildPaymentData(\App\Models\Order $order): array
    {
        $hash = $this->generateHash($order->order_number, $order->total);

        // Split name into first and last
        $nameParts = explode(' ', trim($order->shipping_name), 2);
        $firstName = $nameParts[0];
        $lastName  = $nameParts[1] ?? 'Customer'; // Payhere might require a last name

        $paymentData = [
            'merchant_id'  => $this->merchantId,
            'return_url'   => route('payment.return'),
            'cancel_url'   => route('payment.cancel'),
            'notify_url'   => route('payment.notify'),
            'order_id'     => $order->order_number,
            'items'        => "Order " . $order->order_number, // Simplified
            'amount'       => number_format($order->total, 2, '.', ''),
            'currency'     => 'LKR',
            'hash'         => $hash,
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'email'        => $order->shipping_email,
            'phone'        => $order->shipping_phone,
            'address'      => $order->shipping_address,
            'city'         => $order->shipping_city,
            'country'      => 'Sri Lanka',
        ];

        \Log::debug('Payhere Payment Data', $paymentData);

        return $paymentData;
    }


    public function verifyNotification(array $data): bool
    {
        $localHash = strtoupper(md5(
            $data['merchant_id'] .
            $data['order_id'] .
            $data['payhere_amount'] .
            $data['payhere_currency'] .
            $data['status_code'] .
            strtoupper(md5($this->merchantSecret))
        ));
        return $localHash === $data['md5sig'];
    }
}
