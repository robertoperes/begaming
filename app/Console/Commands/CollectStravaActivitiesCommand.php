<?php

namespace App\Console\Commands;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Services\UserPointBadgeService;
use App\Services\UserStravaActivitService;
use App\Services\UserStravaService;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Strava;

class CollectStravaActivitiesCommand extends Command
{

    protected $signature   = 'collect_strava_activities';
    protected $description = 'Coleta as atividades realizadas pelos colaboradores no Strava';

    /* @var UserStravaService */
    protected $userStravaService;
    /* @var UserStravaActivitService */
    protected $userStravaActivitService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    public function __construct()
    {
        $this->userStravaService        = app(UserStravaService::class);
        $this->userStravaActivitService = app(UserStravaActivitService::class);
        $this->userPointBadgeService    = app(UserPointBadgeService::class);
        parent::__construct();
    }

    public function handle()
    {

        $timeStampStart = Carbon::now('UTC')->subDays(7);
        $users = $this->userStravaService->getActiveUsers();
        $now   = Carbon::now('UTC');
        $perPage = 100;

        if (empty($users)) {
            $this->info('Nenhum usuário encontrado para atualização!');
            return;
        }

        foreach ($users as $userStrava) {

            $this->info('Sincronizando atividades '.$userStrava->user->name);
            try {
                $parseDate = Carbon::parse($userStrava->admission_date)->startOfDay();
                $startTime = $parseDate->timestamp < $timeStampStart->timestamp ?
                    $timeStampStart->timestamp : $parseDate->timestamp;

                $page = 1;
                $allActivities = [];

                do {

                    $activities = Strava::activities($userStrava->access_token, $page, $perPage, $now->timestamp, $startTime);
                    $page++;

                    foreach ($activities as $activity) {
                        $allActivities[] = $activity;
                    }

                    $total = count($activities);
                } while ($total === $perPage);

            } catch (ClientException $exception) {
                if ($exception->getResponse()->getStatusCode() == 429) {
                    $this->warn('Too Many Requests');
                    break;
                } elseif($exception->getResponse()->getStatusCode() == 401) {
                    $this->warn('Conexão com strava expirada para usuário '.$userStrava->user->name);
                    $this->userStravaService->update($userStrava, [
                        'active' => false
                    ]);
                    continue;
                } else {
                    $this->error($exception->getMessage());
                    $this->error($exception->getTraceAsString());
                    continue;
                }

            } catch (\Exception $exception) {
                $this->info('Falha ao obter atividades do usuário ' . $userStrava->user->name);
                $this->error($exception->getMessage());
                $this->error($exception->getTraceAsString());
                continue;
            }

            $this->userStravaService->update($userStrava, [
                'last_fetch_at' => Carbon::now()->toDateTimeString()
            ]);

            if (empty($allActivities)) {
                continue;
            }

            foreach ($allActivities as $activity) {
                DB::beginTransaction();
                $this->userStravaActivitService->createActivity($userStrava, $activity);
                $this->userPointBadgeService->createWellBeingPoint($userStrava, $activity);
                DB::commit();
            }

        }
    }
}
