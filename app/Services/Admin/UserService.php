<?php

namespace App\Services\Admin;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserService
{
    /**
     * Return a paginated list of users ordered by orders count desc.
     * Supports search (name / email / mobile) and presence-based filters.
     */
    public function getPaginatedUsers(
        ?string $search,
        ?string $filter,
        int $perPage = 15,
    ): LengthAwarePaginator {
        return User::query()
            ->withCount('orders')
            ->with('beautyProfile:id,user_id') // lightweight – only to know whether it exists
            ->search($search)
            ->when($filter === 'has_orders',          fn ($q) => $q->hasOrders())
            ->when($filter === 'no_orders',           fn ($q) => $q->noOrders())
            ->when($filter === 'has_beauty_profile',  fn ($q) => $q->hasBeautyProfile())
            ->orderByDesc('orders_count')
            ->paginate($perPage);
    }

    /**
     * Return a single user with their beauty profile (skin type, concerns, ingredients)
     * and all their addresses.
     */
    public function getUserDetail(int|string $id): User
    {
        return User::withCount('orders')
            ->with([
                'addresses',
                'beautyProfile.skinType',
                'beautyProfile.skinConcerns',
                'beautyProfile.preferredIngredients',
                'beautyProfile.avoidedIngredients',
            ])
            ->findOrFail($id);
    }

    /**
     * Return a single user with their wishlist products.
     */
    public function getUserFavorites(int|string $id): User
    {
        return User::with(['wishListItems.categories', 'wishListItems.brand'])
            ->findOrFail($id);
    }

    /**
     * Stream an Excel file containing all users matching the given search/filter.
     */
    public function exportToExcel(?string $search, ?string $filter): BinaryFileResponse
    {
        return Excel::download(
            new UsersExport($search, $filter),
            'users_' . now()->format('Y_m_d_His') . '.xlsx'
        );
    }
}
