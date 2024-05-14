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
        $nowTimeStamp   = Carbon::now()->timestamp;

        foreach ($userActives as $user) {

            try {

                $expiresTimeStamp = !is_null($user->expires_at) ? Carbon::parse($user->expires_at)->timestamp : 0;

                if ($expiresTimeStamp < $nowTimeStamp) {
                    $refresh = Strava::refreshToken($user->refresh_token);
                    $this->userStravaService->update($user,['active' => false]);
                    $this->userStravaService->create([
                        'user_id' => $user->user->id,
                        'active' => true,
                        'expires_at' => Carbon::parse($user->expires_at)->toDateTimeString(),
                        'athlete_id' => $user->athlete_id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'access_token'  => $refresh->access_token,
                        'refresh_token' => $refresh->refresh_token
                    ]);
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