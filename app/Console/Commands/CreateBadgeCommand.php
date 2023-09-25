<?php

namespace App\Console\Commands;

use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Services\UserBadgeService;
use App\Services\UserPointBadgeHistoryService;
use App\Services\UserPointBadgeService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\Traits\Boundaries;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateBadgeCommand extends Command
{

    protected $signature   = 'create_badge';
    protected $description = 'Gera os badges';

    protected $expiresPoints = [
        BadgeTypeEnum::ADMIRATION,
        BadgeTypeEnum::EVOLUTION,
        BadgeTypeEnum::ENGAGEMENT,
        BadgeTypeEnum::WELL_BEING
    ];

    /* @var UserService */
    protected $userService;

    /* @var UserBadgeService */
    protected $userBadgeService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    /* @var UserPointBadgeHistoryService */
    protected $userPointBadgeHistoryService;

    public function __construct()
    {
        $this->userService                  = app(UserService::class);
        $this->userBadgeService             = app(UserBadgeService::class);
        $this->userPointBadgeService        = app(UserPointBadgeService::class);
        $this->userPointBadgeHistoryService = app(UserPointBadgeHistoryService::class);
        parent::__construct();
    }

    public function handle()
    {

        $now   = Carbon::now('UTC');
        $total = 0;

        try {
            $users = $this->userPointBadgeService->rankingUsersPointsBadges();

            if (empty($users)) {
                return;
            }

            foreach ($users as $user) {

                if ($user->total < $user->value) {
                    continue;
                }

                try {

                    DB::beginTransaction();

                    $badge = $this->userBadgeService->create([
                        'user_id'    => $user->user_id,
                        'badge_id'   => $user->badge_id,
                        'created_at' => $now->format('Y-m-d H:i:s'),
                    ]);

                    $this->info('Criando badge ' . $user->badge_name . ' Pontos: ' . $user->value . ' de ' . $user->total);

                    if (in_array($user->badge_type_id, $this->expiresPoints)) {

                        $this->userPointBadgeHistoryService->create([
                            'user_id'       => $user->user_id,
                            'badge_type_id' => $user->badge_type_id,
                            'value'         => ($user->value * -1)
                        ]);

                        $this->info('Compensando Total ' . $user->total . ' de ' . $user->value);
                    }
                    $total++;
                    DB::commit();

                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    DB::rollBack();
                }

            }
            $this->info('Inserido total de ' . $total . ' badges criados.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}