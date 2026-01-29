<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderDashboardController extends Controller
{
    public function index()
    {
        $provider = Auth::user();

        if ($provider->role !== 'provider') {
            abort(404);
        }
        $payments=Payment::where('provider_id', $provider->id)->get();
        $services = Service::where('user_id', $provider->id)->get();
        $bookings = Booking::whereIn('service_id', $services->pluck('id'))
            ->with('user', 'service')
            ->paginate();

        return view('admin.dashboard.provider', compact('services', 'bookings','payments'));
    }

    public function services()
    {
        $provider = Auth::user();
        $services = Service::where('user_id', $provider->id)->paginate();
        return view('provider.services.index', compact('services'));
    }

    public function bookings()
    {
        $provider = Auth::user();
        $services = Service::where('user_id', $provider->id)->pluck('id');
        $bookings = Booking::whereIn('service_id', $services)->paginate();
        return view('provider.bookings.index', compact('bookings'));
    }
}
