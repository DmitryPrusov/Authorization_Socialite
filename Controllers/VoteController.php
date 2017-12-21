<?php

namespace App\Http\Controllers;

use App\Nominee;
use App\SocialAccount;
use App\Vote;


class VoteController extends Controller
{
    public function voteAuthorized($nominationId, $nomineeId)
    {

        $social_user = SocialAccount::where('id',  auth()->guard('social_user')->user()->id)
            ->first();

        $vote = new Vote;
        $vote->nomination_id = $nominationId;
        $vote->nominee_id = $nomineeId;
        $vote->user_agent = request()->header('User-Agent');
        $vote->ip_address = request()->ip();

        if ($vote->isPossible($nomineeId)) {
            $vote->voterId()->associate($social_user);
            $vote->save();
        }

        $nominee = Nominee::where('id', $nomineeId)
            ->first();

        $link = route('nominee.nomination.page', [$nominee->nominationId->slug, $nominee->slug]);
        
        return redirect()->to($link);
        
    }
}

