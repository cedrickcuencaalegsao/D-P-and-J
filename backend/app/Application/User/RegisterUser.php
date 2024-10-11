<?php

namespace App\Application\User;


use App\Domain\User\UserRepository;
use App\Domain\User\User;

class RegisterUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function create(int $id, int $roleID, string $name, string $email, string $password)
    {
        $data = new User($id, $roleID, $name, $email, $password);
        $this->userRepository->create($data);
    }
    public function update(int $id, int $roleID, string $name, string $email, string $password)
    {
        $validate = $this->userRepository->findByID($id);
        if (!$validate) {
            throw new \Exception('Product Not Found!');
        }
        $updateUser = new User(
            id: $id,
            roleID: $roleID,
            name: $name,
            email: $email,
            password: $password,
        );
        $this->userRepository->update($updateUser);
    }
    public function findByID(int $id)
    {
        return $this->userRepository->findByID($id);
    }
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
}
