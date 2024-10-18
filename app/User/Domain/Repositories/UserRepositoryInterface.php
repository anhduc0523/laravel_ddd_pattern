<?php

namespace App\User\Domain\Repositories;

use App\User\Domain\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function update(int $id, array $data): bool;
    public function delete(int $id): void;
}
