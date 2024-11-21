<?php

namespace App\Application\User;


use App\Domain\User\UserRepository;
use App\Domain\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function updateToken(int $id, string $apiToken)
    {
        return $this->userRepository->updateToken($id, $apiToken);
    }
    /**
     * Login.
     * **/
    public function login(string $email, string $password)
    {
        // if ($this->userRepository->findByEmail($email)) {
        //     throw new \Exception("Account not found!");
        // }
        return $this->userRepository->login($email, $password);
    }
    public function create(int $roleID, string $firstname, string $lastname, string $email, string $password)
    {
        // Check if user already exists
        if ($this->userRepository->findByEmail($email)) {
            throw new \Exception('Email already exists!');
        }
        $data = new User(
            null,
            $roleID,
            $firstname,
            $lastname,
            $email,
            $password
        );
        return $this->userRepository->create($data);
    }
    public function update(int $id, int $roleID, string $firstName, string $lastName, string $email, string $password)
    {
        $validate = $this->userRepository->findByID($id);
        if (!$validate) {
            throw new \Exception('Product Not Found!');
        }
        $updateUser = new User(
            id: $id,
            roleID: $roleID,
            firstName: $firstName,
            lastName: $lastName,
            email: $email,
            password: $password,
        );
        $this->userRepository->update($updateUser);
    }
    public function findByID(int $id)
    {
        return $this->userRepository->findByID($id);
    }
    public function findByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
    public function addApiToken(int $id, string $apiToken)
    {
        $this->userRepository->addApiToken($id, $apiToken);
    }
    public function removeApiToken(int $id)
    {
        $this->userRepository->removeApiToken($id);
    }
}
