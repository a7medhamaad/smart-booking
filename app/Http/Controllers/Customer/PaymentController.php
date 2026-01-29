<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function checkout(Service $service)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $customer = Auth::user();
        $provider = $service->provider;

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $service->name,
                    ],
                    'unit_amount' => $service->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['service' => $service->id]),
            'cancel_url' => route('payment.cancel'),
        ]);

        Payment::create([
            'user_id' => $customer->id,
            'provider_id' => $provider->id,
            'service_id' => $service->id,
            'amount' => $service->price,
            'status' => 'pending',
        ]);

        return redirect($session->url);
    }

    public function success(Service $service)
    {
        $payment = Payment::where('service_id', $service->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($payment) {
            $payment->update([
                'status' => 'success',
                'transaction_id' => 'txn_' . uniqid(),
            ]);

            // ✅ استرجع بيانات الحجز اللي اتخزنت مؤقتاً
            $bookingData = session('booking_data');

            if ($bookingData) {
                // احفظ الحجز في قاعدة البيانات
                \App\Models\Booking::create([
                    'user_id' => Auth::id(),
                    'service_id' => $bookingData['service_id'],
                    'booking_date' => $bookingData['booking_date'],
                    'status' => 'confirmed',
                ]);

                // امسح البيانات من الـ session بعد التخزين
                session()->forget('booking_data');
            }
        }

        return redirect()->route('customer.bookings.index')->with('success', 'Payment successful! Booking confirmed.');
    }

    public function cancel()
    {
        return redirect()->route('customer.dashboard')->with('error', 'Payment cancelled.');
    }
}
