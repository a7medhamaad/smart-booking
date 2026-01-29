<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::user();

        if ($customer->role !== 'customer') {
            abort(404);
        }

        // جلب كل الحجوزات الخاصة بالعميل
        $bookings = Booking::where('user_id', $customer->id)
            ->with('service', 'service.provider')
            ->latest()
            ->get();

        return view('admin.dashboard.customer', compact('bookings'));
    }
}
