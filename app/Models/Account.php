<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Foundation\Auth\User;
use Laravel\Passport\HasApiTokens;

#[Fillable(['name'])]
class Account extends User
{
    use HasApiTokens;
}
