<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = User::where('user_type', User::TYPE_CUSTOMER);

        if ($request->filled('search')) {
            $term = '%'.trim($request->input('search')).'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('city', 'like', $term);
            });
        }

        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->input('city').'%');
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $customers = $query->latest()->paginate($perPage);

        $stats = [
            'total' => User::where('user_type', User::TYPE_CUSTOMER)->count(),
            'active' => User::where('user_type', User::TYPE_CUSTOMER)->where('is_active', true)->count(),
        ];

        return $this->ok(UserResource::collection($customers->items()), 'Customers retrieved.', [
            'current_page' => $customers->currentPage(),
            'per_page' => $customers->perPage(),
            'total' => $customers->total(),
            'last_page' => $customers->lastPage(),
            'stats' => $stats,
        ]);
    }

    public function toggle(User $customer): JsonResponse
    {
        abort_unless((int) $customer->user_type === User::TYPE_CUSTOMER, 404);

        $customer->update(['is_active' => ! $customer->is_active]);
        $statusText = $customer->is_active ? 'activated' : 'suspended';

        return $this->ok(new UserResource($customer->fresh()), "Customer account {$customer->name} has been {$statusText}.");
    }

    public function destroy(User $customer): JsonResponse
    {
        abort_unless((int) $customer->user_type === User::TYPE_CUSTOMER, 404);

        $name = $customer->name;
        $customer->delete();

        return $this->ok(null, "Customer {$name} removed successfully.");
    }
}
