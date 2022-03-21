<?php

namespace App\Http\Controllers;

use App\Http\Resources\BadgeResourceCollection;
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
        $data    = new UserPointBadgeResourceCollection($this->userPointBadgeService->list($filters, 'id', 'DESC'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function listUserBadge()
    {
        $user = $this->userService->get(auth()->user()->id);
        $data = new BadgeResourceCollection($user->badges()->get());
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function ranking()
    {

    }
}