<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NomineeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
