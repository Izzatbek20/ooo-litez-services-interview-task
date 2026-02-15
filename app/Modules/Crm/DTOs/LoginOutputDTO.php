<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Models\User;

readonly class LoginOutputDTO
{
    public function __construct(
        public User $user,
        public string $token,
        public string $token_type = 'Bearer',
    ) {}

    public function toArray()
    {
        return [
            'user' => $this->user,
            'token' => $this->token,
            'token_type' => $this->token_type,
        ];
    }
}
