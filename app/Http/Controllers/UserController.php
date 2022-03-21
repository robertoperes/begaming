<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Services\UserService;
use CodeToad\Strava\Strava;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserController extends Controller
{
    /* @var UserService */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function me(Request $request)
    {
        $user = $this->userService->get(auth()->user()->id);
        $data = new UserResource($user);
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function get()
    {
        $user = $this->userService->get(auth()->user()->id);
        $data = new UserResource($user);
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function list(Request $request)
    {
        $filters = [
            'page' => $request->get('page')
        ];
        $data = new UserResourceCollection($this->userService->list($filters,'name'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

}