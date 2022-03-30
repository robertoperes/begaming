<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Services\UserService;
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

    public function get(Request $request)
    {
        $user = $this->userService->get($request->id);
        $data = new UserResource($user);
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function list(Request $request)
    {
        $filters = [
            'page' => $request->get('page')
        ];
        $data    = new UserResourceCollection($this->userService->list($filters, 'name'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function create(Request $request)
    {
        $data = new UserResource($this->userService->create($request->all()));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function update(Request $request)
    {
        $user = $this->userService->get($request->id);
        $data = new UserResource($this->userService->update($user,
            $request->all()));
        return Response::json($data, HttpResponse::HTTP_OK);
    }
}