<?php

namespace App\User\Domain\Services;

use App\User\Application\DTO\UserDto;
use App\User\Application\UseCases\CreateUserUseCase;
use App\User\Application\UseCases\DeleteUserUseCase;
use App\User\Application\UseCases\GetUserByEmailUseCase;
use App\User\Application\UseCases\GetUserByIdUseCase;
use App\User\Application\UseCases\UpdateUserUseCase;
use App\User\Domain\Models\User;

readonly class UserService
{
    public function __construct(
        private CreateUserUseCase     $createUserUseCase,
        private GetUserByIdUseCase    $getUserByIdUseCase,
        private GetUserByEmailUseCase $getUserByEmailUseCase,
        private UpdateUserUseCase     $updateUserUseCase,
        private DeleteUserUseCase     $deleteUserUseCase
    ) {}

    public function createUser(array $data): User
    {
        $userDTO = UserDto::fromArray($data);

        return $this->createUserUseCase->execute($userDTO);
    }

    public function getUserById(int $id): array
    {
        return $this->getUserByIdUseCase->execute($id);
    }

    public function getUserByEmail(string $email): array
    {
        return $this->getUserByEmailUseCase->execute($email);
    }

    public function updateUser(int $id, array $data): array
    {
        $userDTO = UserDto::fromArray($data);
        $this->updateUserUseCase->execute($id, $userDTO);

        return $userDTO->toArray();
    }

    public function deleteUser(int $id): void
    {
        $this->deleteUserUseCase->execute($id);
    }
}
