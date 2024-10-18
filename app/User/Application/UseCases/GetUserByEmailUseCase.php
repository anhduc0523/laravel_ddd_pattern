<?php

namespace App\User\Application\UseCases;

use App\User\Application\Mappers\UserMapperInterface;
use App\User\Domain\Repositories\UserRepositoryInterface;

readonly class GetUserByEmailUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserMapperInterface $userMapper
    ) {}

    public function execute(string $email): array
    {
        $user = $this->userRepository->findByEmail($email);

        return $this->userMapper->toDTO($user)->toArray();
    }
}
