<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserPointBadgeResource;
use App\Http\Resources\UserPointBadgeResourceCollection;
use App\Http\Resources\UserPointBadgeStatusResource;
use App\Http\Resources\UserPointBadgeStatusResourceCollection;
use App\Services\UserPointBadgeService;
use App\Services\UserPointBadgeStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserPointBadgeController extends Controller
{

    /* @var UserPointBadgeService */
    protected $userPointBadgeService;

    /* @var UserPointBadgeStatusService */
    protected $userPointBadgeStatusService;

    public function __construct(
        UserPointBadgeService       $userPointBadgeService,
        UserPointBadgeStatusService $userPointBadgeStatusService
    ) {
        $this->userPointBadgeService       = $userPointBadgeService;
        $this->userPointBadgeStatusService = $userPointBadgeStatusService;
    }

    public function get(Request $request)
    {
        $data = new UserPointBadgeResource($this->userPointBadgeService->get($request->id));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function list(Request $request)
    {
        $filters = [
            'page' => $request->get('page')
        ];
        $data    = new UserPointBadgeResourceCollection($this->userPointBadgeService->list($filters, 'created_at'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function listStatus()
    {
        $data = new UserPointBadgeStatusResourceCollection($this->userPointBadgeStatusService->list([
            'active' =>
                true
        ], 'description'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function create(Request $request)
    {
        $data = new UserPointBadgeResource($this->userPointBadgeService->create(
            array_merge($request->all(), ['input_user_id' => auth()->user()->id])
        ));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function update(Request $request)
    {
        $userPointBadge = $this->userPointBadgeService->get($request->id);
        $data           = new UserPointBadgeResource($this->userPointBadgeService->update($userPointBadge,
            $request->all()));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

}