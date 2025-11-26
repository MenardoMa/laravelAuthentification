<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    protected $fillable = [
        'github',
        'facebook',
        'linkedin',
        'instagram',
        'twitter',
        'youtube',
    ];
}
