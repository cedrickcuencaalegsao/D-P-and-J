<?php

namespace App\Domain\User;

interface UserRepository
{
    public function create(User $user): void;
    public function update(User $user): void;
    public function findByID(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function findAll(): array;
    public function addApiToken(int $id, string $apiToken): void;
    public function removeApiToken(int $id): void;
}
