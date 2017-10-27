<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class AccentSchema extends Schema
{
    protected $type = 'accent-content';

    public function getAttributes($resource)
    {
        return [
            'order'      => $resource->sort,
            'accent'     => $resource->content->title,
            'summary'    => $resource->content->summary,
            'color'      => $resource->content->color,
            'background' => $resource->content->background,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        return false;
    }
}
