<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'nominee_id',
        'votes_quantity',
        'nomination_id',
        'voter_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function voterId()
    {
        return $this->belongsTo(SocialAccount::class, 'voter_id', 'id');
    }

    public function scopeIfVoted($query, $nominee_id)
    {
        return $query->where('nominee_id', $nominee_id)
            ->where('updated_at', '>', Carbon::now()->subDay())
            ->where('voter_id', auth()->guard('social_user')->user()->id);
    }

    public function isPossible($nominee_id)
    {
        return !$this->ifVoted($nominee_id)
            ->exists();
    }
    public function nominationId()
    {
        return $this->belongsTo(Nomination::class, 'nomination_id', 'id');
    }
    public function nomineeId()
    {
        return $this->belongsTo(Nominee::class, 'nominee_id', 'id');
    }
}
