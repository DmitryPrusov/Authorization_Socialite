<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SocialAccount extends Authenticatable
{
    protected $guard = 'social_user';
    protected $table = 'voters';
    
    protected $fillable = [
        'profile',
        'nominee_id',
        'votes_quantity',
        'profile',
        'email',
        'name',
        'provider',
        'updated_at'
    ];

    
    public function nomineeId() {
        
        return $this->belongsTo(Nominee::class);
    }

    public function scopeCheckDate($query, Carbon $yesterday) {

        $query->where('updated_at', '<=', $yesterday);
    }
}
