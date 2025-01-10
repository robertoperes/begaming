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

    protected $signature = 'culture_point';
    protected $description = 'Gera os pontos de Cultura';

    protected $pointBadgeWeight = [
        BadgeClassificationEnum::CLASSIC => 1,
        BadgeClassificationEnum::SILVER => 2,
        BadgeClassificationEnum::GOLD => 3,
        BadgeClassificationEnum::BLACK => 4,
    ];

    /* @var UserService */
    protected $userService;

    /* @var UserBadgeService */
    protected $userBadgeService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
        $this->userBadgeService = app(UserBadgeService::class);
        $this->userPointBadgeService = app(UserPointBadgeService::class);
        parent::__construct();
    }

    public function handle()
    {

        $now = Carbon::now('UTC');
        $total = 0;

        $users = $this->userService->findAll(['active' => true]);

        if (empty($users)) {
            return;
        }

        foreach ($users as $user) {

            try {

                $userBadges = $this->userBadgeService->findAll([
                    'user_id' => $user->id
                ]);

                $points = $this->userPointBadgeService->findAll([
                    'user_id' => $user->id,
                    'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                    'badge_type_id' => BadgeTypeEnum::CULTURE,
                ]);

                if (!count($userBadges)) {
                    continue;
                }

                $listUniqueBadges = [];
                $pointValues = 0;
                $sum = 0;

                foreach ($userBadges as $userBadge) {
                    $typeId = $userBadge->badge->type->id;
                    $classificationId = $userBadge->badge->classification->id;

                    if ($typeId == BadgeTypeEnum::CULTURE) {
                        continue;
                    }

                    if (!array_key_exists($typeId, $listUniqueBadges) ||
                        $listUniqueBadges[$typeId] < $classificationId
                    ) {
                        $listUniqueBadges[$typeId] = $classificationId;
                    }
                }

                foreach ($listUniqueBadges as $classificationId) {
                    $sum += $this->pointBadgeWeight[$classificationId];
                }

                foreach ($points as $point) {
                    $pointValues += $point->value;
                }

                $value = $sum - $pointValues;

                if ($value < 1) {
                    continue;
                }

                $this->info('Criando ponto de cultura ' . $value . ' para ' . $user->name);
                $this->userPointBadgeService->create([
                    'user_id' => $user->id,
                    'badge_type_id' => BadgeTypeEnum::CULTURE,
                    'user_point_badge_status_id' => UserPointBadgeStatusEnum::APPROVED,
                    'input_user_id' => $user->id,
                    'event_date' => $now->format('Y-m-d'),
                    'description' => 'Pontos de cultura',
                    'value' => $value,
                ]);
                $total++;

            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
                $this->error($exception->getTraceAsString());
            }
        }

        $this->info('Inserido total de ' . $total . ' pontos de cultura.');
    }
}