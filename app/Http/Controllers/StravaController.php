<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use App\Services\UserStravaService;
use Strava;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StravaController extends Controller
{

    /* @var UserStravaService */
    protected $userStravaService;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(UserStravaService $userStravaService)
    {
        $this->userStravaService = $userStravaService;
    }

    public function redirectToStravaProvider()
    {
        return Strava::authenticate($scope = 'read_all,profile:read_all,activity:read_all');
    }

    public function handleStravaProviderCallback(Request $request)
    {

        $token   = Strava::token($request->code);
        $athlete = Strava::athlete($token->access_token);

        try {
            $userStrava = $this->userStravaService->findByUser(auth()->user()->id);
            $this->userStravaService->update(
                $userStrava,
                [
                    'athlete_id'    => $athlete->id,
                    'access_token'  => $token->access_token,
                    'refresh_token' => $token->refresh_token,
                    'updated_at'    => Carbon::now('UTC')->toDateTimeString(),
                    'expires_at'    => Carbon::parse($token->expires_at)->toDateTimeString()
                ]
            );
        } catch (\Exception $e) {
            $this->userStravaService->create(
                [
                    'user_id'       => auth()->user()->id,
                    'athlete_id'    => $athlete->id,
                    'access_token'  => $token->access_token,
                    'refresh_token' => $token->refresh_token,
                    'created_at'    => Carbon::now('UTC')->toDateTimeString(),
                    'expires_at'    => Carbon::parse($token->expires_at)->toDateTimeString()
                ]
            );
        }

        return redirect()->route('home');
    }

}