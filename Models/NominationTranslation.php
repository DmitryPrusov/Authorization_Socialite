<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NominationTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
}
