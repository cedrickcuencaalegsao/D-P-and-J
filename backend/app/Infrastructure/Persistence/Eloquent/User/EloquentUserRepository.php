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
        return new User($data->id, $data->roleID, $data->name, $data->email);
    }
    public function create(User $user): void
    {
        $data = UserModel::find($user->getId() ?? new UserModel());
        $data->id = $user->getId();
        $data->roleID = $user->getRoleID();
        $data->name = $user->getName();
        $data->email = $user->getEmail();
        $data->id = $user->getPassword();
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
            name: $data->name,
            email: $data->email,
        ))->toArray();
    }
}
