<?php

namespace App\Console\Commands;

use App\Http\Resources\Dashboard\RankingUsersPointsBadgesResourceCollection;
use App\Services\UserPointBadgeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheDashboardCommand extends Command
{

    protected $signature   = 'cache_dashboard';
    protected $description = 'Gera cache do dashboard';

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;
    public function __construct()
    {
        $this->userPointBadgeService        = app(UserPointBadgeService::class);
        parent::__construct();
    }

    public function handle()
    {
        $expiresAt  = Carbon::now()->addHours(24);
        $keyCache   = 'cache-dashboard-' . Carbon::now('America/Sao_Paulo')->format('Ymd');
        $cache      = [];

        try {
            $data = (new RankingUsersPointsBadgesResourceCollection(
                $this->userPointBadgeService->rankingUsersPointsBadges()
            ))->toArray(request());

            foreach ($data['data'] as $keyBadge => $badges){
                foreach ($badges['users'] as $key => $user){
                    $cache[$keyBadge]['rank'][$user['id']] = $key;
                }
            }

            if(Cache::has($keyCache)){
                Cache::forget($keyCache);
            }

            Cache::put($keyCache, json_encode($cache), $expiresAt);

            $this->info('Cache atualizado com sucesso. ');
        } catch (\Exception $exception) {
            $this->error('Falha ao atualizar cache');
            throw $exception;
        }
    }
}