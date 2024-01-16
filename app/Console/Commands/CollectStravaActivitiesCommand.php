<?php

namespace App\Console\Commands;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Models\UserStravaActivit;
use App\Services\UserPointBadgeService;
use App\Services\UserStravaActivitService;
use App\Services\UserStravaService;
use Carbon\Carbon;
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

            try {
                if (strtotime(Carbon::now()) > $user->expires_at) {
                    $refresh = Strava::refreshToken($user->refresh_token);
                    $this->userStravaService->update($user, [
                        'access_token'  => $refresh->access_token,
                        'refresh_token' => $refresh->refresh_token
                    ]);
                    $user->access_token  = $refresh->access_token;
                    $user->refresh_token = $refresh->refresh_token;
                }
            } catch (\Exception $exception) {
                $this->userStravaService->update($user, ['active' => false]);
                $this->info('Falha ao renovar token do usuário ' . $user->id . '. Erro: ' . $exception->getMessage());
                continue;
            } catch (\Error $error) {
                $this->userStravaService->update($user, ['active' => false]);
                $this->info('Falha ao renovar token do usuário ' . $user->id . '. Erro: ' . $error->getMessage());
                continue;
            }

            try {
                $parseDate = Carbon::parse($user->admission_date)->startOfDay();
                $startTime = $parseDate->timestamp < $timeStampStart->timestamp ?
                    $timeStampStart->timestamp : $parseDate->timestamp;

                $activities = Strava::activities($user->access_token, 1, 100, $now->timestamp,
                    $startTime);
            } catch (\Exception $exception) {
                $this->userStravaService->update($user, ['active' => false]);
                $this->info('Falha ao obter atividades do usuário ' . $user->id . '. Erro: ' . $exception->getMessage());
                continue;
            } catch (\Error $error) {
                $this->userStravaService->update($user, ['active' => false]);
                $this->info('Falha ao obter atividades do usuário ' . $user->id . '. Erro: ' . $error->getMessage());
                continue;
            }

            if (empty($activities)) {
                continue;
            }

            foreach ($activities as $activit) {

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
                        'event_date'                 => $activitDate->format('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }
}
