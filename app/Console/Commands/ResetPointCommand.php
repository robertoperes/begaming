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

class ResetPointCommand extends Command
{

    protected $signature = 'reset_point';
    protected $description = 'Reseta pontos';

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    /* @var UserPointBadgeHistoryService */
    protected $userPointBadgeHistoryService;

    public function __construct()
    {
        $this->userPointBadgeService = app(UserPointBadgeService::class);
        $this->userPointBadgeHistoryService = app(UserPointBadgeHistoryService::class);
        parent::__construct();
    }

    public function handle()
    {

        $now = Carbon::now('UTC');
        $total = 0;

        try {
            $points = $this->userPointBadgeService->listUserPointsBadgesReset($now->format('Y'));

            if (empty($points)) {
                return;
            }

            foreach ($points as $point) {

                $value = ($point->total + ($point->total_history));

                if ($value) {
                    continue;
                }

                try {

                    DB::beginTransaction();

                    $history = $this->userPointBadgeHistoryService->create([
                        'user_id'       => $point->user_id,
                        'badge_type_id' => $point->badge_type_id,
                        'value'         => $value * -1,
                        'description'   => 'Resete de pontos anual',
                        'created_at'    => $now->format('Y-01-01 H:i:s'),
                    ]);

                    $total++;
                    DB::commit();

                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    DB::rollBack();
                }

            }
            $this->info('Resetado total de ' . $total . ' pontos.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}