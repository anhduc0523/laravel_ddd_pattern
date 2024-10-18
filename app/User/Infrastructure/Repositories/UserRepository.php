<?php

namespace App\User\Infrastructure\Repositories;

use App\User\Domain\Models\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * @throws Exception
     */
    public function update(int $id, array $data): bool
    {
        $user = $this->findById($id);
        if (!$user) {
            throw new Exception('User not found');
        }

        return $user->update($data);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $user = $this->findById($id);
        if (!$user) {
            throw new Exception('User not found');
        }

        $user->delete();
    }
}
