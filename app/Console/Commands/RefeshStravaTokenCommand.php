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

        $userActives = $this->userStravaService->getActiveUsers();

        foreach ($userActives as $user) {

            try {

                $refresh = Strava::refreshToken($user->refresh_token);

                if($refresh->access_token != $user->access_token) {
                    $this->userStravaService->update($user, [
                        'active'  => false,
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);

                    $this->userStravaService->create([
                        'user_id'       => $user->user->id,
                        'athlete_id'    => $user->athlete_id,
                        'access_token'  => $refresh->access_token,
                        'refresh_token' => $refresh->refresh_token,
                        'expires_at' => Carbon::parse($refresh->expires_at)->toDateTimeString(),
                        'created_at' => Carbon::now()->toDateTimeString()
                    ]);
                } else {
                    $this->userStravaService->update($user, [
                        'expires_at' => Carbon::parse($refresh->expires_at)->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                }

                $this->info('Token atualizado para usuário '. $user->user->name);
            } catch (\Exception $exception) {
                $this->error('Falha ao atualizar token usuário '.$user->user_id);
                $this->error($exception->getMessage());
                $this->error($exception->getTraceAsString());
            }

        }

    }
}