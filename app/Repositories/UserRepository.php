<?php

namespace App\Repositories;

use App\Helpers\AuthHelper;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Services\QueryFilteringService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class UserRepository extends CrudRepository implements UserRepositoryInterface
{
    private QueryFilteringService $queryFilteringService;

    public function __construct(User $user, QueryFilteringService $queryFilteringService)
    {
        parent::__construct($user);
        $this->queryFilteringService = $queryFilteringService;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        $query = $this->model::query();

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByUser($authUser, $query);
        }

        if ($login = Arr::get($input, 'login')) {
            $query = $query->where('login', 'like', '%' . $login . '%');
        }

        if ($firstName = Arr::get($input, 'first_name')) {
            $query = $query->where('first_name', 'like', '%' . $firstName . '%');
        }

        if ($lastName = Arr::get($input, 'last_name')) {
            $query = $query->where('last_name', 'like', '%' . $lastName . '%');
        }

        if ($email = Arr::get($input, 'email')) {
            $query = $query->where('email', 'like', '%' . $email . '%');
        }

        if ($isAdmin = Arr::get($input, 'is_admin')) {
            $query = $query->where('is_admin', $isAdmin);
        }

        return $query->paginate($perPage, $columns);
    }
}
