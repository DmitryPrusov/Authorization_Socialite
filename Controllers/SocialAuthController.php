<?php

namespace App\Http\Controllers;

use App\Nomination;
use App\Nominee;
use App\SocialAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use App\Vote;

class SocialAuthController extends Controller
{
    protected $providers = [
        'facebook',
        'google',
    ];

    public function redirectToProvider($driver)
    {
        session(['nomination_id' => request()->nomination_id]);
        session(['nominee_id' => request()->nominee_id]);
        
        $nominee = Nominee::where('id', request()->nominee_id)
            ->first();
        session(['our_link' => route('nominee.nomination.page', [$nominee->nominationId->slug, $nominee->slug])]);

        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("Вхід через {$driver} зараз не підтримується");
        }

        try {
           return Socialite::driver($driver)->redirect();
        }
        catch (Exception $e)
        {
            return $this->sendFailedResponse($e->getMessage());
        }

    }

    public function handleProviderCallback($driver)
    {
        try {
            $user =  Socialite::driver($driver)->user();
        }
        catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        $this->firstOrCreateUser($user, $driver);


        $ourLink = session('our_link');
        session()->forget('our_link');

        return Redirect::to($ourLink)->with('message', 'Ваш голос успішно зарахований!');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $ProviderUser
     * @return User
     */

    private function firstOrCreateUser($ProviderUser, $driver)
    {
        if ($driver == 'facebook') {
            $profileLink = 'http://' . $driver . '.com/' . $ProviderUser->getId();
        } elseif ($driver == 'google') {
            $profileLink = 'http://plus.' . $driver . '.com/' . $ProviderUser->getId();
        }

        $nomination_id = (int) session('nomination_id');
        $nominee_id = (int) session('nominee_id');

        session()->forget('nomination_id');
        session()->forget('nominee_id');

        $social_user = SocialAccount::firstOrCreate([
            'profile' => $profileLink,
            'provider' => $driver,
            'email' => $ProviderUser->getEmail(),
            'name' => $ProviderUser->getName(),
        ]);
        

        if (!$this->guard()->check()) {
            $this->guard()->login($social_user, true);
        }
        // или УЖЕ залогинен, и хочет проголосовать за нового провайдера - тогда разлогинить, и залогинить за нового провайдера:
        elseif ($this->guard()->check() and $this->guard()->user()->profile != $profileLink) {
            auth()->logout();
            $this->guard()->login($social_user, true);

        }

        $vote = new Vote;
        $vote->nomination_id = $nomination_id;
        $vote->nominee_id = $nominee_id;
        $vote->user_agent = request()->header('User-Agent');
        $vote->ip_address = request()->ip();

        if ($vote->isPossible($nominee_id)) {
            $vote->voterId()->associate($social_user);
            $vote->save();
        }

        return $social_user;
    }

    protected function guard(){
        return Auth::guard('social_user');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->back()
            ->withErrors(['msg' => $msg ?: 'Невозможно залогиниться']);
    }

    private function isProviderAllowed($driver) 
    {
        return in_array($driver, $this->providers);
    }
    
}
