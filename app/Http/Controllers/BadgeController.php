<?php

namespace App\Http\Controllers;

use App\Http\Resources\BadgeClassificationResourceCollection;
use App\Http\Resources\BadgeResource;
use App\Http\Resources\BadgeResourceCollection;
use App\Http\Resources\BadgeTypeResourceCollection;
use App\Services\BadgeClassificationService;
use App\Services\BadgeService;
use App\Services\BadgeTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class BadgeController extends Controller
{

    /* @var BadgeService */
    protected $badgeService;
    /* @var BadgeTypeService */
    protected $badgeTypeService;
    /* @var BadgeClassificationService */
    protected $badgeClassificationService;

    public function __construct(
        BadgeService               $badgeService,
        BadgeTypeService           $badgeTypeService,
        BadgeClassificationService $badgeClassificationService
    ) {
        $this->badgeService               = $badgeService;
        $this->badgeTypeService           = $badgeTypeService;
        $this->badgeClassificationService = $badgeClassificationService;
        $this->middleware('auth');
    }

    public function get(Request $request)
    {
        $data = new BadgeResource($this->badgeService->get($request->id));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function list(Request $request)
    {
        $filters = [
            'page' => $request->get('page')
        ];
        $data = new BadgeResourceCollection($this->badgeService->list($filters, 'value'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function types()
    {
        $data = new BadgeTypeResourceCollection($this->badgeTypeService->list(['active' => true], 'description'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function classifications()
    {
        $data = new BadgeClassificationResourceCollection($this->badgeClassificationService->list(['active' => true],
            'description'));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function create(Request $request)
    {
        $data  = new BadgeResource($this->badgeService->create($request->all()));
        return Response::json($data, HttpResponse::HTTP_OK);
    }

    public function update(Request $request)
    {
        $badge = $this->badgeService->get($request->id);
        $data  = new BadgeResource($this->badgeService->update($badge, $request->all()));
        return Response::json($data, HttpResponse::HTTP_OK);
    }
}