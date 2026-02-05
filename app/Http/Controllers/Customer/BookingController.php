<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show all bookings of the authenticated customer.
     */
    public function index()
    {
        $customer = Auth::user();

        if ($customer->role !== 'customer') {
            abort(403, 'Unauthorized access');
        }

        $bookings = Booking::with(['service', 'service.provider'])
            ->where('user_id', $customer->id)
            ->latest()
            ->get();

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $services = Service::all();
        return view('customer.bookings.create', compact('services'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $existingBooking = Booking::where('user_id', auth()->id())
            ->where('service_id', $request->service_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return redirect()
                ->back()
                ->with('error', 'Service Can not Booking at this time Finsh service you Book and try later.');
        }

        session([
            'booking_data' => [
                'service_id' => $request->service_id,
                'booking_date' => $request->booking_date,
            ]
        ]);

        return redirect()->route('payment.checkout', $request->service_id);
    }

    public function edit(Booking $booking)
    {
        $customer = Auth::user();

        if ($booking->user_id !== $customer->id) {
            abort(403, 'Unauthorized access');
        }

        $services = Service::all();

        return view('customer.bookings.edit', compact('booking', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $booking->update([
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
        ]);

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }



    public function show(Booking $booking)
    {
        $customer = Auth::user();

        if ($booking->user_id !== $customer->id) {
            abort(403, 'Unauthorized access');
        }

        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     */
    public function destroy(Booking $booking)
    {
        $customer = Auth::user();

        if ($booking->user_id !== $customer->id) {
            abort(403, 'Unauthorized access');
        }

        $booking->delete();

        return redirect()->route('customer.bookings.index')
            ->with('success', 'تم إلغاء الحجز بنجاح');
    }
}
