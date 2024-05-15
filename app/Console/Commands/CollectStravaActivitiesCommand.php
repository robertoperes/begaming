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

        $timeStampStart = Carbon::now('UTC')->setDay(1)->setMonth(1)->startOfDay();
        $users = $this->userStravaService->getActiveUsers();
        $now   = Carbon::now('UTC');

        if (empty($users)) {
            $this->info('Nenhum usuário encontrado para atualização!');
            return;
        }

        foreach ($users as $user) {

            $this->info('Sincronizando '.$user->user->name);
            try {
                $parseDate = Carbon::parse($user->admission_date)->startOfDay();
                $startTime = $parseDate->timestamp < $timeStampStart->timestamp ?
                    $timeStampStart->timestamp : $parseDate->timestamp;

                $page = 1;
                $allActivities = [];

                //do {

                    $this->info('Buscando page '.$page);
                    $allActivities = Strava::activities($user->access_token, 1, 100, $now->timestamp, $startTime);
                    $page++;

                    //foreach ($activities as $activit) {
                    //    $allActivities[] = $activit;
                    //}

                //} while (count($activities));

            } catch (ClientException $exception) {
                if($exception->getResponse()->getStatusCode() == 429) {
                    $this->warn('Too Many Requests');
                    break;
                } else {
                    $this->error($exception->getMessage());
                    $this->error($exception->getTraceAsString());
                    continue;
                }

            } catch (\Exception $exception) {
                $this->info('Falha ao obter atividades do usuário ' . $user->user->name);
                $this->error($exception->getMessage());
                $this->error($exception->getTraceAsString());
                continue;
            }

            $this->userStravaService->update($user, [
                'last_fetch_at' => Carbon::now()->toDateTimeString()
            ]);

            if (empty($allActivities)) {
                continue;
            }

            foreach ($allActivities as $activit) {

                $activitDate = Carbon::parse($activit->start_date_local,
                    $activit->timezone);

                $data = [
                    'id'               => $activit->id,
                    'user_strava_id'   => $user->id,
                    'active'           => true,
                    'name'             => $activit->name,
                    'type'             => $activit->type,
                    'start_date_local' => $activitDate->format('Y-m-d H:i:s'),
                    'elapsed_time'     => $activit->elapsed_time,
                ];

                try {
                    $activitModel = $this->userStravaActivitService->get($activit->id);
                    $this->userStravaActivitService->update($activitModel, $data);
                } catch (\Exception $exception) {
                    $this->userStravaActivitService->create($data);
                }

                $event = $activitDate->format('Ym') == '202401' ? ' Campanha Janeiro Branco' : '';
                $value = $activitDate->format('Ym') == '202401' ? 2 : 1;

                try {
                    $point = $this->userPointBadgeService->findBadgeTypeDate($user->user_id, BadgeTypeEnum::WELL_BEING,
                        $activitDate->format('Y-m-d'));
                } catch (\Exception $exception) {
                    $this->userPointBadgeService->create([
                        'user_id'                    => $user->user_id,
                        'badge_type_id'              => BadgeTypeEnum::WELL_BEING,
                        'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                        'input_user_id'              => $user->user_id,
                        'value'                      => $value,
                        'description'                => 'Atividade Strava'.$event,
                        'event_date'                 => $activitDate->format('Y-m-d 00:00:00')
                    ]);
                }
            }
        }
    }
}
