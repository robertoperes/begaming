<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class ResourceCollectionAbstract extends ResourceCollection
{

    private $meta;

    public function __construct($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            $this->meta = [
                __('total', [])        => $resource->total(),
                __('count', [])        => $resource->count(),
                __('per_page', [])     => $resource->perPage(),
                __('current_page', []) => $resource->currentPage(),
                __('last_page', [])    => $resource->lastPage(),
                __('from', [])         => $resource->firstItem(),
                __('to', [])           => $resource->lastItem(),
            ];
            $resource   = $resource->getCollection();
        }

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        if (is_null($this->meta)) {
            return $this->collection;
        }

        return [
            'data'  => $this->collection,
            'meta'  => $this->meta,
        ];
    }
}