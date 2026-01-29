<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderPaymentController extends Controller
{
    public function index()
    {
        $provider = Auth::user();

        $payments = Payment::whereHas('service', function ($query) use ($provider) {
            $query->where('provider_id', $provider->id);
        })
            ->with(['user', 'service'])
            ->latest()
            ->paginate(5);

        return view('provider.payments.index', compact('payments'));
    }
}
