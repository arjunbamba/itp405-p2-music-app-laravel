<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // For Mass Assignment in create_roles_table migration
    protected $fillable = ['slug', 'name'];

    public static function getUser()
    {
        // For RegistrationController
        // return Role::where('slug', '=', 'user')->first();
        return self::where('slug', '=', 'user')->first();
    }
}
