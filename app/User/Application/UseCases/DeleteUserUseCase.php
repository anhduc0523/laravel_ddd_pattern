<?php

namespace App\User\Application\UseCases;

use App\User\Domain\Repositories\UserRepositoryInterface;

readonly class DeleteUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $id): void
    {
        $this->userRepository->delete($id);
    }
}
