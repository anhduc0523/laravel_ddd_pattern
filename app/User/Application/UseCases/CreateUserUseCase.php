<?php

namespace App\User\Application\UseCases;

use App\User\Application\DTO\UserDto;
use App\User\Application\Mappers\UserMapperInterface;
use App\User\Domain\Models\User;
use App\User\Domain\Repositories\UserRepositoryInterface;

readonly class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserMapperInterface $userMapper
    ) {}

    public function execute(UserDto $userDto): User
    {
        $user = $this->userMapper->toDomain($userDto);

        return $this->userRepository->create($user->makeVisible(['password'])->toArray());
    }
}
