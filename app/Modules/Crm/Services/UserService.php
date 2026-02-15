<?php

namespace App\Modules\Crm\Services;

use App\Modules\Crm\DTOs\UserDTO;
use App\Modules\Crm\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(UserDTO $userDTO): User
    {
        // qiymati nullga teng itemlarni o'chirib yuboramiz
        $userData = array_filter($userDTO->toArray());

        return User::query()->create([
            ...$userData,
            'password' => Hash::make($userDTO->password),
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
