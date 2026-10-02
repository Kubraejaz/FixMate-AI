<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a paginated directory of registered customers with search & filters.
     */
    public function index(Request $request): View
    {
        $query = User::where('user_type', User::TYPE_CUSTOMER);

        if ($request->filled('q')) {
            $term = '%' . trim($request->input('q')) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('email', 'like', $term)
                  ->orWhere('phone', 'like', $term)
                  ->orWhere('city', 'like', $term);
            });
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        $totalCount = User::where('user_type', User::TYPE_CUSTOMER)->count();
        $activeCount = User::where('user_type', User::TYPE_CUSTOMER)->where('is_active', true)->count();
        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('Frontend.admin.customers', compact('customers', 'totalCount', 'activeCount'));
    }

    /**
     * Toggle customer account active / suspended status.
     */
    public function toggle(User $customer): RedirectResponse
    {
        $customer->update(['is_active' => ! $customer->is_active]);

        $statusText = $customer->is_active ? 'activated' : 'suspended';

        return back()->with('success', "Customer account {$customer->name} has been {$statusText}.");
    }

    /**
     * Delete customer account.
     */
    public function destroy(User $customer): RedirectResponse
    {
        $name = $customer->name;
        $customer->delete();

        return back()->with('success', "Customer {$name} removed successfully.");
    }
}
