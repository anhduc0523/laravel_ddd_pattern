<?php

namespace App\User\Infrastructure\Mappers;

use App\User\Application\DTO\UserDto;
use App\User\Application\Mappers\UserMapperInterface;
use App\User\Domain\Models\User;

class UserMapper implements UserMapperInterface
{
    public function toDTO(User $user): UserDto
    {
        return new UserDTO(
            name: $user->name,
            email: $user->email,
        );
    }

    public function toDomain(UserDTO $userDTO): User
    {
        return new User([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => $userDTO->password
        ]);
    }
}
