<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Builder;

/**
 * фикс бага пхпшторма TODO потом убрать
 * @property boolean $timestamps
 */

class User extends Authenticatable
{

    protected $primaryKey = 'user_id';

    protected $table = 'users';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_email',
        'user_password',
        'user_salt',
        'user_name',
        'user_address',
        'user_cart',
        'user_phone',
        'created_at'
    ];

    public static function getGroupByEmail($user_email) {
        return User::where('user_email', $user_email)
            ->first()
            ->user_group;
    }
}

