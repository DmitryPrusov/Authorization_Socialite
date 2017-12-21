<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('oauth/{driver}', [
    'uses' => 'SocialAuthController@redirectToProvider',
    'as'=> 'oauth.route']);

Route::get('oauth/{driver}/callback', 'SocialAuthController@handleProviderCallback');


Route::get('/nominees/{nominationSlug}/{nomineeSlug}', ['uses' => 'PageController@nomineeNomination', 'as' => 'nominee.nomination.page']);
Route::get('/vote/{nominationId}/{nomineeId}', ['uses' => 'VoteController@voteAuthorized', 'as' => 'vote.authorized']);

