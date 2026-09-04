<?php

namespace App\Enums;

enum UserRole: string
{
    case Member = 'MEMBER';
    case Admin = 'ADMIN';
    case Editor = 'EDITOR';
}
