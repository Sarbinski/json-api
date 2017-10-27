<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class CtaSchema extends Schema
{
    protected $type = 'cta';

    public function getAttributes($resource)
    {
        return [
            'order'  => $resource->sort,
            'title'  => $resource->content->title,
            'link'   => $resource->content->link,
            'target' => (bool)$resource->content->target,
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
