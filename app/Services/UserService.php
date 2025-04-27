<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Create User Account
     */
    public function create($data)
    {
        return User::create($data);
    }
}