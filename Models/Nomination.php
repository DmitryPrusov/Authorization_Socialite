<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\EdipresseTranslatable;

class Nomination extends Model
{
    use EdipresseTranslatable;

    public $timestamps = false;

    protected $translatable = [
        'name',
        'slug',
        'description'
    ];

    protected $fillable = [
        'position',
        'active'
    ];

    protected $with = ['translations'];

    public function experts()
    {
        return $this->belongsToMany(Expert::class);
    }

    public function nominees()
    {
        return $this->hasMany(Nominee::class);
    }

    public function getUrlAttribute()
    {
        if (!isset($this->id)) {
            return '';
        }

        return url('nominations/' . $this->slug);
    }



    public function getRandomImageAttribute()
    {
        if (!$this->nominees()->where('year', '2017')->count()) {
            return '';
        }
            return ($this->nominees()->where('year', '2017')
                ->inRandomOrder()
                ->first()
                ->getCroppedPhoto('slider', 'norm')
            );
    }

    public function scopeGetByYear($query)
    {
        return $query->where('year', request()->year)->get();
    }

    public function redirect($request)
    {
        return redirect('admin/nominations?year=2017')->with([
            'message' => __('voyager.generic.successfully_updated'),
            'alert-type' => 'success',
        ]);
    }
    public function thisYearNominees() {

        return $this->nominees()->where('year','=', 2017);
    }

}
