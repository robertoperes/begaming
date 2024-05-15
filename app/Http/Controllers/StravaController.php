<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Services\UserPointBadgeService;
use App\Services\UserStravaActivitService;
use App\Services\UserStravaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Strava;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class StravaController extends Controller
{

    /** @var UserStravaService $userStravaService */
    protected $userStravaService;

    /** @var UserStravaActivitService $userStravaActivitService */
    protected $userStravaActivitService;

    /** @var UserPointBadgeService $userPointBadgeService */
    protected $userPointBadgeService;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(
        UserStravaService $userStravaService,
        UserStravaActivitService $userStravaActivitService,
        UserPointBadgeService $userPointBadgeService
    )
    {
        $this->userStravaService = $userStravaService;
        $this->userStravaActivitService = $userStravaActivitService;
        $this->userPointBadgeService = $userPointBadgeService;
    }

    public function redirectToStravaProvider()
    {
        return Strava::authenticate($scope = 'read_all,profile:read_all,activity:read_all');
    }

    public function providerCallback(Request $request)
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

    public function subscribeCallback(Request $request): JsonResponse
    {
        $data = [
            'hub.challenge' => $request['hub_challenge'] ?? null,
        ];
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function inputSubscribeCallback(Request $request): JsonResponse
    {

        try {
            $data = $request->all();
            if($request->get('object_type') == 'activity') {
                $userStrava = $this->userStravaService->findActiveTokenBy('athlete_id', $data['owner_id']);
                $activity   = Strava::activity($userStrava->access_token, $data['object_id']);
                DB::beginTransaction();
                $this->userStravaActivitService->createActivity($userStrava, $activity);
                $this->userPointBadgeService->createWellBeingPoint($userStrava, $activity);
                DB::commit();
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            return Response::json([
                'message' => 'Falha atualização atividade do usuário',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        }
        return Response::json([], HttpResponse::HTTP_OK);
    }

}