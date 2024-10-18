<?php

namespace App\User\Presentation\Http\Controllers\Api;

use App\User\Domain\Services\UserService;
use App\User\Presentation\Http\Controllers\Controller;
use App\User\Presentation\Http\Requests\CreateUserRequest;
use App\User\Presentation\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function store(CreateUserRequest $request) : JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return $this->successResponse($user,'User created successfully');
    }

    public function getUserById(int $id) : JsonResponse
    {
        $user = $this->userService->getUserById($id);

        return $this->successResponse($user,'User fetched successfully');
    }

    public function getUserByEmail(string $email) : JsonResponse
    {
        $user = $this->userService->getUserByEmail($email);

        return $this->successResponse($user,'User fetched successfully');
    }

    public function update(UpdateUserRequest $request, int $id) : JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());

        return $this->successResponse($user,'User updated successfully');
    }

    public function delete(int $id) : Response
    {
        $this->userService->deleteUser($id);

        return $this->noContentResponse();
    }
}
