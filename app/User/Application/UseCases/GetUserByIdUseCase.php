<?php

namespace App\User\Application\UseCases;

use App\User\Application\Mappers\UserMapperInterface;
use App\User\Domain\Repositories\UserRepositoryInterface;

readonly class GetUserByIdUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserMapperInterface $userMapper
    ) {}

    public function execute(int $id): array
    {
        $user = $this->userRepository->findById($id);

        return $this->userMapper->toDTO($user)->toArray();
    }
}
