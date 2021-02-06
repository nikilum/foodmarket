<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    protected $table = 'email_verify';

    protected $fillable = [
        'user_id',
        'verify_code',
        'created_at',
        'updated_at'
        ];
}
