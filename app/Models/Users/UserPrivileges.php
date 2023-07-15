<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivileges extends Model
{
    use HasFactory;

    protected $table = 'user_privileges';
    protected $guarded = [];
}
