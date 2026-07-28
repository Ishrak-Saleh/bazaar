<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(): View
    {
        $vendors = User::where('role', 'vendor')->latest()->get();

        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve(User $vendor): RedirectResponse
    {
        abort_unless($vendor->role === 'vendor', 404);

        $vendor->update(['vendor_status' => 'approved']);

        return back()->with('success', 'Vendor approved.');
    }

    public function reject(User $vendor): RedirectResponse
    {
        abort_unless($vendor->role === 'vendor', 404);

        $vendor->update(['vendor_status' => 'rejected']);

        return back()->with('success', 'Vendor rejected.');
    }
}
