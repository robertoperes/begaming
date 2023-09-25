<?php

namespace App\Console\Commands;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Services\UserPointBadgeService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\Traits\Boundaries;
use Illuminate\Console\Command;

class CompanyTimePointCommand extends Command
{

    protected $signature   = 'company_time_point';
    protected $description = 'Gera os pontos de Tempo de Empresa';

    /* @var UserService */
    protected $userService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    public function __construct()
    {
        $this->userService           = app(UserService::class);
        $this->userPointBadgeService = app(UserPointBadgeService::class);
        parent::__construct();
    }

    public function handle()
    {

        $now   = Carbon::now('UTC');
        $total = 0;

        try {
            $users = $this->userService->findAll(['active' => true]);

            if (empty($users)) {
                return;
            }

            foreach ($users as $user) {
                $admissionDate = Carbon::parse($user->admission_date);
                $years         = $admissionDate->diffInYears($now);

                if (!$years) {
                    continue;
                }

                $date = Carbon::parse($user->admission_date)->addYear(1);
                for ($i = 1; $i <= $years; $i++) {
                    try {
                        $point = $this->userPointBadgeService->findBadgeTypeDate($user->id, BadgeTypeEnum::COMPANY_TIME,
                            $date->format('Y-m-d'));
                    } catch (\Exception $exception) {
                        $info = $user->name;
                        $info .= ' Admissão: ' . $admissionDate->format('d/m/Y');
                        $info .= ' Ponto: ' . $date->format('d/m/Y');
                        $this->info($info);
                        $this->userPointBadgeService->create([
                            'user_id'                    => $user->id,
                            'badge_type_id'              => BadgeTypeEnum::COMPANY_TIME,
                            'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                            'input_user_id'              => $user->id,
                            'event_date'                 => $date->format('Y-m-d'),
                            'description'                => 'Tempo de Empresa',
                            'value'                      => 1,
                        ]);
                        $total++;
                    }
                    $date->addYear(1);
                }
            }
            $this->info('Inserido total de '.$total.' pontos.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}