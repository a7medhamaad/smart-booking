<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services for this provider.
     */
    public function index()
    {
        $provider = Auth::user();

        $services = Service::with('category')
            ->where('user_id', $provider->id)
            ->get();

        return view('provider.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $categories = Category::all();
        return view('provider.services.create', compact('categories'));
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $provider = Auth::user();

        // ✅ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id']);
        $data['user_id'] = $provider->id;
        $data['is_approved'] = false; // 👈 الخدمة تحتاج موافقة الأدمن

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('provider.services.index')
            ->with('success', 'Service submitted successfully and is pending admin approval.');
    }

    /**
     * Show the specified service.
     */
    public function show(Service $service)
    {
        $this->authorizeService($service);
        return view('provider.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $this->authorizeService($service);

        // ❌ لا يمكن تعديل الخدمة بعد الموافقة (اختياري)
        if ($service->is_approved) {
            return redirect()->route('provider.services.index')
                ->with('error', 'Approved services cannot be edited.');
        }

        $categories = Category::all();
        return view('provider.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service)
    {
        $this->authorizeService($service);

        // ❌ منع تعديل خدمة معتمدة
        if ($service->is_approved) {
            return redirect()->route('provider.services.index')
                ->with('error', 'Approved services cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id']);

        if ($request->hasFile('image')) {
            if ($service->image && file_exists(storage_path('app/public/' . $service->image))) {
                unlink(storage_path('app/public/' . $service->image));
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('provider.services.index')
            ->with('success', 'Service updated successfully and will need re-approval.');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        $this->authorizeService($service);
        $service->delete();

        return redirect()->route('provider.services.index')
            ->with('success', 'Service deleted successfully!');
    }

    /**
     * Ensure the service belongs to the authenticated provider.
     */
    private function authorizeService(Service $service)
    {
        if ($service->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
