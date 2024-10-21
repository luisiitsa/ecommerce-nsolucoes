<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $userRepository;

    /**
     * Constructor method to initialize the UserRepository instance.
     *
     * @param UserRepository $userRepository The UserRepository instance being injected into the constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Search method to paginate users from UserRepository.
     */
    public function search()
    {
        return $this->userRepository->paginate();
    }

    /**
     * Find a record by its ID in the database.
     *
     * @param int $id The ID of the record to find.
     * @return mixed The found record.
     */
    public function find($id): mixed
    {
        return $this->userRepository->find($id);
    }

    /**
     * Creates a new User record in the database.
     *
     * @param array $data The data for creating the User, including 'password' which will be hashed.
     * @return User The newly created User object.
     */
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    /**
     * Update a user record in the database.
     *
     * @param int $id The ID of the user record to update.
     * @param array $data The data to update the user record with.
     * @return User The updated User object.
     */
    public function update(int $id, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($data, $id);
    }

    /**
     * Deletes a record from the database.
     *
     * @param int $id The ID of the record to be deleted.
     * @return int The number of records deleted.
     */
    public function delete(int $id): int
    {
        return $this->userRepository->delete($id);
    }
}
