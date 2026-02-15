<?php

namespace App\Modules\Crm\Services;

use App\Modules\Crm\DTOs\LoginInputDTO;
use App\Modules\Crm\DTOs\LoginOutputDTO;
use App\Modules\Crm\DTOs\UserDTO;
use App\Modules\Crm\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected UserService $user_service
    ) {}

    public function register(UserDTO $userDTO): User
    {
        return $this->user_service->create($userDTO);
    }

    public function login(LoginInputDTO $loginInputDTO): ?LoginOutputDTO
    {
        $user = $this->user_service->findByEmail($loginInputDTO->email);

        if (! $user || ! Hash::check($loginInputDTO->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Login yoki parol noto‘g‘ri.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return new LoginOutputDTO($user, $token);
    }
}
