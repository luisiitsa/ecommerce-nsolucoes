<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'cpf'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * Finds a user by their login credentials.
     *
     * @param string $login The user's login credential.
     * @param string $loginType The type of login credential to search by.
     * @return User|null The user object if found, null otherwise.
     */
    public function findByLogin(string $login, string $loginType): ?User
    {
        return User::where($loginType, $login)->first();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
