<?php

namespace App\Http\Controllers;

use App\Nomination;

class PageController extends Controller
{
 
    public function nomineeNomination($nominationSlug, $nomineeSlug)
    {
        $nomination = Nomination::whereTranslation('slug', '=', $nominationSlug)
            ->where('active', 1)
            ->where('year', 2017)
            ->firstOrFail();
        return view('pages.single-nominee', compact('nomination', 'nomineeSlug'));
    }

}

