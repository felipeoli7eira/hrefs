<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialNetwork extends Model
{
    use HasFactory;

    protected $table = 'social_networks';

    protected $fillable = [
        'user_id',
        'facebook',
        'instagram',
        'linkedin'
    ];
}
