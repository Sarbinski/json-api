<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

/**
 * Description of AboutCirclesSchema
 *
 */
class AboutCirclesSchema extends Schema
{
    protected $type = 'about-circles';

    public function getAttributes($resource)
    {
        return [
            'title' => $resource->title,
            'items' => $resource->items,
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
