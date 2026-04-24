<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GetUsersRequest;
use App\Http\Resources\Admin\UserDetailResource;
use App\Http\Resources\Admin\UserFavoritesResource;
use App\Http\Resources\Admin\UserListResource;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * GET /admin/users
     * Paginated list of users ordered by orders count desc,
     * with search (name / email / mobile) and filter support.
     */
    public function index(GetUsersRequest $request): AnonymousResourceCollection
    {
        $users = $this->userService->getPaginatedUsers(
            search:  $request->search,
            filter:  $request->filter,
            perPage: (int) ($request->per_page ?? 15),
        );

        return UserListResource::collection($users);
    }

    /**
     * GET /admin/users/{user}
     * User profile with beauty profile and addresses.
     */
    public function show(int $user): UserDetailResource
    {
        return new UserDetailResource(
            $this->userService->getUserDetail($user)
        );
    }

    /**
     * GET /admin/users/{user}/favorites
     * User's wishlist / favourite products.
     */
    public function favorites(int $user): UserFavoritesResource
    {
        return new UserFavoritesResource(
            $this->userService->getUserFavorites($user)
        );
    }

    /**
     * GET /admin/users/export
     * Download an Excel file of the current listing (same search + filter).
     */
    public function export(GetUsersRequest $request): BinaryFileResponse
    {
        return $this->userService->exportToExcel(
            search: $request->search,
            filter: $request->filter,
        );
    }
}
