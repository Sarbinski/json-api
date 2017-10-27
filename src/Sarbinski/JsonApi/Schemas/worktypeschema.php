<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class WorkTypeSchema extends Schema
{
    protected $type = 'work-type';

    public function getAttributes($resource)
    {
        return [
            'title'    => $resource->title,
            'slug'     => $resource->slug,
            'order'    => $this->addOrdering(),
            'selected' => false,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        return null;
    }
}
