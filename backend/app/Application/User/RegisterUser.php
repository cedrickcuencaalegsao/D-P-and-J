<?php

namespace App\Application\User;


use App\Domain\User\UserRepository;
use App\Domain\User\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function create(int $id, int $roleID, string $name, string $email, string $password)
    {
        // Check if user already exists
        if ($this->userRepository->findByEmail($email)) {
            throw new \Exception('Email already exists!');
        }

        // Hash the password before saving
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = new User($id, $roleID, $name, $email, $hashedPassword);
        $this->userRepository->create($data);
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
    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !password_verify($credentials['password'], $user->getPassword())) {
            return null;
        }

        $payload = [
            'sub' => $user->getId(),
            'role' => $user->getRoleID(),
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        return JWTAuth::fromUser($user, $payload);
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
