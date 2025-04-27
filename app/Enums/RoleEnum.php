<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case COMPANY = 'company';
    case PARTICIPANT = 'participant';
}
