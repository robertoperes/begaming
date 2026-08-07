<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Services\UserPointBadgeService;
use App\Services\UserStravaActivitService;
use App\Services\UserStravaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        if ($request->filled('error')) {
            Log::warning('Strava OAuth negado ou cancelado pelo usuário', [
                'error' => $request->get('error'),
                'user_id' => optional(auth()->user())->id,
            ]);
            return redirect()->route('home')->with('error', 'Autorização do Strava não concedida.');
        }

        if (!$request->filled('code')) {
            Log::warning('Strava callback chamado sem "code"', $request->all());
            return redirect()->route('home')->with('error', 'Retorno inválido do Strava.');
        }

        $user = auth()->user();
        if (!$user) {
            Log::warning('Strava callback chamado sem usuário autenticado (sessão perdida no redirect)');
            return redirect()->route('login')->with('error', 'Sua sessão expirou, faça login novamente para conectar o Strava.');
        }

        try {
            $token   = Strava::token($request->code);
            $athlete = Strava::athlete($token->access_token);
        } catch (\Exception $e) {
            Log::error('Falha ao trocar code por token / buscar athlete no Strava: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id'   => $user->id,
            ]);
            return redirect()->route('home')->with('error', 'Não foi possível conectar ao Strava. Tente novamente.');
        }

        try {
            $userStrava = $this->userStravaService->findByUser($user->id);
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
                    'user_id'       => $user->id,
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

    public function subscribeCallback(Request $request)
    {
        $mode       = $request->get('hub_mode');
        $token      = $request->get('hub_verify_token');
        $challenge  = $request->get('hub_challenge');

        if ($mode === 'subscribe' && $token === 'STRAVA_BEFORE') {
            return response()->json(['hub.challenge' => $challenge], HttpResponse::HTTP_OK);
        }

        return response('Forbidden', HttpResponse::HTTP_FORBIDDEN);
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
            return response()->json([
                'message' => 'Falha atualização atividade do usuário',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        }
        return response()->json([], HttpResponse::HTTP_OK);
    }

}