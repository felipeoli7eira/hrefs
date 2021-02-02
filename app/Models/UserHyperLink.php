<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHyperLink extends Model
{
    use HasFactory;

    protected $table = 'hyperlinks';

    protected $fillable = [
        'user_id',
        'label',
        'ref'
    ];
}
