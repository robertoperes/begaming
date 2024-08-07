<?php

namespace App\Console\Commands;

use App\Services\UserStravaService;
use Carbon\Carbon;
use Strava;
use Illuminate\Console\Command;

class RefeshStravaTokenCommand extends Command
{

    protected $signature = 'refresh_strava_token';
    protected $description = 'Atualiza token autenticação Strava';

    /* @var UserStravaService */
    protected $userStravaService;

    public function __construct()
    {
        $this->userStravaService        = app(UserStravaService::class);
        parent::__construct();
    }

    public function handle()
    {

        $userActives    = $this->userStravaService->getExpiredUsers();
        $nowTimeStamp   = Carbon::now('UTC')->timestamp;

        foreach ($userActives as $user) {

            try {

                $expiresTimeStamp = Carbon::parse($user->expires_at)->timestamp;

                if ($expiresTimeStamp < $nowTimeStamp) {
                    $refresh = Strava::refreshToken($user->refresh_token);
                    if($refresh->access_token !== $user->access_token) {
                        $this->userStravaService->update($user,[
                            'active' => false
                        ]);
                        $this->userStravaService->create([
                            'user_id'       => $user->user->id,
                            'active'        => true,
                            'expires_at'    => Carbon::parse($refresh->expires_at)->toDateTimeString(),
                            'athlete_id'    => $user->athlete_id,
                            'last_fetch_at' => $user->last_fetch_at,
                            'created_at'    => Carbon::now('UTC')->toDateTimeString(),
                            'access_token'  => $refresh->access_token,
                            'refresh_token' => $refresh->refresh_token
                        ]);
                        $this->info('Token atualizado para usuário '. $user->user->name);
                    } else {
                        $this->userStravaService->update($user,[
                            'created_at'    => Carbon::now('UTC')->toDateTimeString(),
                            'expires_at'    => Carbon::parse($refresh->expires_at)->toDateTimeString(),
                            'access_token'  => $refresh->access_token,
                            'refresh_token' => $refresh->refresh_token
                        ]);
                    }
                    $this->info('Token atualizado para usuário '. $user->user->name);
                }
            } catch (\Exception $exception) {
                $this->error('Falha ao atualizar token usuário '.$user->user_id);
                $this->error($exception->getMessage());
                $this->error($exception->getTraceAsString());
            }

        }

    }
}