<?php

namespace App\Console\Commands;

use App\Enuns\BadgeClassificationEnum;
use App\Enuns\BadgeTypeEnum;
use App\Enuns\UserPointBadgeStatusEnum;
use App\Services\UserBadgeService;
use App\Services\UserPointBadgeService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CulturePointCommand extends Command
{

    protected $signature   = 'culture_point';
    protected $description = 'Gera os pontos de Cultura';

    protected $pointBadgeWeight = [
        BadgeClassificationEnum::CLASSIC => 1,
        BadgeClassificationEnum::SILVER  => 2,
        BadgeClassificationEnum::GOLD    => 3,
        BadgeClassificationEnum::BLACK   => 4,
    ];

    /* @var UserService */
    protected $userService;

    /* @var UserBadgeService */
    protected $userBadgeService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    public function __construct()
    {
        $this->userService           = app(UserService::class);
        $this->userBadgeService      = app(UserBadgeService::class);
        $this->userPointBadgeService = app(UserPointBadgeService::class);
        parent::__construct();
    }

    public function handle()
    {

        $now   = Carbon::now('UTC');
        $total = 0;

        $users = $this->userService->findAll(['active' => true]);

        if (empty($users)) {
            return;
        }

        foreach ($users as $user) {

            try {

                DB::beginTransaction();

                $userBadges = $this->userBadgeService->findAll([
                    'user_id' => $user->id
                ]);

                $points = $this->userPointBadgeService->findAll([
                    'user_id'                    => $user->id,
                    'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                    'badge_type_id'              => BadgeTypeEnum::CULTURE,
                ]);

                if (!count($userBadges)) {
                    continue;
                }

                $listUniqueBadges = [];
                $pointValues      = [];

                foreach ($userBadges as $userBadge) {
                    $key = $userBadge->badge->type->id . '-' . $userBadge->badge->classification->id;

                    if( $userBadge->badge->type->id == BadgeTypeEnum::CULTURE){
                        continue;
                    }

                    if (array_key_exists($key, $listUniqueBadges)) {
                        continue;
                    }

                    $listUniqueBadges[$key] =
                        $this->pointBadgeWeight[$userBadge->badge->classification->id];
                }

                foreach ($points as $point) {
                    $pointValues[$point->id] = $point->value;
                }

                foreach ($listUniqueBadges as $type_id => $value) {
                    if ($key = array_search(intval($value), $pointValues)) {
                        unset($pointValues[$key]);
                        continue;
                    }

                    $this->info('Criando ponto de cultura ' . $value . ' para ' . $user->name);
                    $this->userPointBadgeService->create([
                        'user_id'                    => $user->id,
                        'badge_type_id'              => BadgeTypeEnum::CULTURE,
                        'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                        'input_user_id'              => $user->id,
                        'event_date'                 => $now->format('Y-m-d'),
                        'description'                => 'Novo badge diferente adquirido',
                        'value'                      => $value,
                    ]);
                    $total++;
                }
                DB::commit();
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
                $this->error($exception->getTraceAsString());
            }
        }
        $this->info('Inserido total de ' . $total . ' pontos de cultura.');
    }
}