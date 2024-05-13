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

                if (strtotime(Carbon::now()) >= $user->expires_at) {
                    $refresh = Strava::refreshToken($user->refresh_token);
                    $this->userStravaService->update($user, [
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