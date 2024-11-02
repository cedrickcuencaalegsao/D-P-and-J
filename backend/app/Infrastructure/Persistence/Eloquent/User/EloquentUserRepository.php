<?php

namespace App\Infrastructure\Persistence\Eloquent\User;

use App\Domain\User\UserRepository;
use App\Domain\User\User;


class EloquentUserRepository implements UserRepository
{
    public function findByID(int $id): ?User
    {
        $data = UserModel::find($id);
        if (!$data) {
            return null;
        }
        return new User($data->id, $data->roleID, $data->firstName, $data->lastName, $data->email, $data->apiToken, $data->created_at, $data->updated_at);
    }
    public function findByEmail(string $email): ?User
    {
        $data = UserModel::where('email', $email)->first();
        if (!$data) {
            return null;
        }
        return new User($data->id, $data->roleID, $data->firstName, $data->lastName, $data->email, $data->apiToken, $data->created_at, $data->updated_at);
    }
    public function create(User $user): void
    {
        $data = new UserModel(); // Always create a new model instance
        $data->roleID = $user->getRoleID();
        $data->firstName = $user->getFirstName();
        $data->lastName = $user->getLastName();
        $data->email = $user->getEmail();
        $data->password = $user->getPassword(); // Store hashed password
        $data->apiToken = $user->getApiToken(); // Set apiToken if necessary
        $data->save();
    }

    public function update(User $user): void
    {
        $data = UserModel::find($user->getId()) ?? new UserModel();
        $data->id = $user->getId();
        $data->roleID = $user->getRoleID();
        $data->email = $user->getEmail();
        $data->password = $user->getPassword();
        $data->save();
    }
    public function findAll(): array
    {
        return UserModel::all()->map(fn($data) => new User(
            id: $data->id,
            roleID: $data->roleID,
            firstName: $data->firstName,
            lastName: $data->lastName,
            email: $data->email,
            apiToken: $data->apiToken,
            created_at: $data->created_at,
            updated_at: $data->updated_at
        ))->toArray();
    }
    public function addApiToken(int $id, string $apiToken): void
    {
        $data = UserModel::find($id);
        $data->apiToken = $apiToken;
        $data->save();
    }
    public function removeApiToken(int $id): void
    {
        $data = UserModel::find($id);
        $data->apiToken = null;
        $data->save();
    }
}
