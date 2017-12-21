<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\CroppedPhotos;
use TCG\Voyager\Traits\EdipresseTranslatable;

class Nominee extends Model
{

    use CroppedPhotos,
        EdipresseTranslatable;

    protected $translatable = [
        'name',
        'slug',
        'description',
    ];

    protected $fillable = [
        'photo',
        'active',
        'created_at',
        'updated_at',
        'votes'
    ];
    protected $with = ['translations'];


    public function nominationId()
    {
        return $this->belongsTo(Nomination::class, 'nomination_id', 'id');
    }
    public function getUrlAttribute()
    {
        if (!isset($this->id)) {
            return '';
        }

        return url('nominees/' . $this->slug);
    }
    public function getUrlImageAttribute()
    {
        if (!isset($this->photo)) {
            return '';
        }
        return url('storage/' . $this->photo);
    }

    public function scopeGetByYear($query)
    {
        return $query->where('year', request()->year)->get();
    }

    public function getIsPossibleVoteAttribute()
    {

        if (auth()->guard('social_user')->check()) {
            $user_id = 0;
            $user_id = auth()->guard('social_user')->user()->id;
            return !Vote::where('voter_id', $user_id)->ifVoted($this->id)->exists();
        }
            return true;
    }

    public function redirect($request)
    {
        return redirect('admin/nominees?year=2017')->with([
            'message' => __('voyager.generic.successfully_updated'),
            'alert-type' => 'success',
        ]);
    }

}
