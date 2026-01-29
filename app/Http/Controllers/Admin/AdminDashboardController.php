<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Category;
use App\Models\Payment;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $servicesCount = Service::count();
            $categoriesCount = Category::count();
            $bookingsCount = Booking::count();
            $paymentsCount = Payment::count();

            $recentServices = Service::latest()->take(5)->get();
            $recentCategories = Category::latest()->take(5)->get();

            $providers = User::where('role', 'provider')->take(5)->get();
            $customers = User::where('role', 'customer')->take(5)->get();
            $admins = User::where('role', 'admin')->take(5)->get();

            return view('admin.dashboard.admin', compact(
                'servicesCount',
                'categoriesCount',
                'bookingsCount',
                'paymentsCount',
                'recentServices',
                'recentCategories',
                'providers',
                'customers',
                'admins'
            ));
        } elseif ($user->role === 'provider') {
            return view('admin.dashboard.provider');
        } else {
            return view('admin.dashboard.customer');
        }
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully!');
}
}
