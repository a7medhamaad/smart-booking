<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function index()
    {
        $provider = Auth::user();

        $bookings = Booking::with(['service', 'user'])
            ->whereHas('service', function ($query) use ($provider) {
                $query->where('user_id', $provider->id);
            })
            ->latest()
            ->paginate(10);

        return view('provider.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {


        return view('provider.bookings.show', compact('booking'));
    }


    public function edit(Booking $booking)
    {

        return view('provider.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return redirect()->route('provider.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }


    public function destroy(Booking $booking)
    {

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('provider.bookings.index')
            ->with('success', 'تم إلغاء الحجز بنجاح.');
    }

    protected function authorizeProviderBooking(Booking $booking)
    {
        if ($booking->service->provider_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذا الحجز.');
        }
    }
}
