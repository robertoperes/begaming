<?php

namespace App\Http\Controllers;

use App\Http\Resources\BadgeResourceCollection;
use App\Http\Resources\Dashboard\RankingBadgeUsersResourceCollection;
use App\Http\Resources\Dashboard\RankingUsersPointsBadgesResourceCollection;
use App\Http\Resources\TotalUserPointBadgeResourceCollection;
use App\Http\Resources\UserPointBadgeResourceCollection;
use App\Services\BadgeService;
use App\Services\UserBadgeService;
use App\Services\UserPointBadgeService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class DashboardController extends Controller
{

    /* @var BadgeService */
    protected $badgeService;

    /* @var UserService */
    protected $userService;

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    /* @var UserBadgeService */
    protected $userBadgeService;

    public function __construct(
        BadgeService          $badgeService,
        UserService           $userService,
        UserPointBadgeService $userPointBadgeService,
        UserBadgeService      $userBadgeService
    ) {
        $this->badgeService          = $badgeService;
        $this->userService           = $userService;
        $this->userBadgeService      = $userBadgeService;
        $this->userPointBadgeService = $userPointBadgeService;
    }

    public function listUserPointBadge(Request $request)
    {
        $filters = [
            'user_id'  => auth()->user()->id,
            'page'     => $request->get('page'),
            'per_page' => $request->get('per_page'),
        ];
        $data    = new UserPointBadgeResourceCollection($this->userPointBadgeService->list($filters, 'event_date',
            'DESC'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function listUserBadge()
    {
        $user = $this->userService->get(auth()->user()->id);
        $data = new BadgeResourceCollection($user->badges()->get());
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function listTotalUserPointBadge()
    {
        $data = new TotalUserPointBadgeResourceCollection($this->userPointBadgeService->listTotalUsersPointsBadges(
            auth()->user()->id
        ));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function rankingBadgeUsers()
    {
        $data = new RankingBadgeUsersResourceCollection($this->userBadgeService->rankingBadgeUsers());
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function rankingUsersPointsBadges()
    {
        $data = new RankingUsersPointsBadgesResourceCollection($this->userPointBadgeService->rankingUsersPointsBadges());
        return Response::json($data, HttpResponse::HTTP_OK);
    }
}