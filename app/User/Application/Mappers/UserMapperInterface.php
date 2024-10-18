<?php

namespace App\User\Application\Mappers;

use App\User\Application\DTO\UserDto;
use App\User\Domain\Models\User;

interface UserMapperInterface
{
    public function toDTO(User $user): UserDto;
    public function toDomain(UserDTO $userDTO): User;
}
