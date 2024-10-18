<?php

namespace App\User\Application\UseCases;

use App\User\Application\DTO\UserDto;
use App\User\Application\Mappers\UserMapperInterface;
use App\User\Domain\Models\User;
use App\User\Domain\Repositories\UserRepositoryInterface;

readonly class UpdateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserMapperInterface $userMapper
    ) {}

    public function execute(int $id, UserDto $userDto): bool
    {
        $user = $this->userMapper->toDomain($userDto);

        return $this->userRepository->update($id, $user->makeVisible(['password'])->toArray());
    }
}
