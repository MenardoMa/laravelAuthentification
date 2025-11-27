<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $fillable = [
        'site_title',
        'site_email',
        'site_phone_number',
        'site_meta_keywords',
        'site_description',
    ];
}
