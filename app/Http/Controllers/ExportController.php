<?php

namespace App\Http\Controllers;

use App\Http\Resources\Export\UserBadgeResourceCollection;
use App\Http\Resources\Export\UserPointBadgeResourceCollection;
use App\Services\UserBadgeService;
use App\Services\UserPointBadgeService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /* @var UserBadgeService */
    protected $userBadgeService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    public function __construct(
        UserBadgeService $userBadgeService,
        UserPointBadgeService $userPointBadgeService
    )
    {
        $this->userBadgeService = $userBadgeService;
        $this->userPointBadgeService = $userPointBadgeService;
    }

    public function badges(Request $request)
    {

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type' => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=badges.csv'
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];

        $columns = ['Nome', 'Badge','Time', 'Data'];

        $listBadges = $this->userBadgeService->findAll(['user.active' => true]);
        $list = (new UserBadgeResourceCollection($listBadges))->toArray($request);

        $callback = function () use ($list, $columns, $request) {
            $this->export($list, $columns, $request);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function userPointsBadge(Request $request)
    {

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type' => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=badges.csv'
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];

        $columns = ['Nome', 'Badge','Time', 'Ponto', 'Descrição','Data'];

        $listBadges = $this->userPointBadgeService->export();
        $list = (new UserPointBadgeResourceCollection($listBadges))->toArray($request);

        $callback = function () use ($list, $columns, $request) {
            $this->export($list, $columns, $request);
        };

        return response()->stream($callback, 200, $headers);
    }

    function export($list, $columns, $request)
    {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns, ';');

        foreach ($list as $row) {
            fputcsv($file, $row->toArray($request), ';');
        }
        fclose($file);
    }
}