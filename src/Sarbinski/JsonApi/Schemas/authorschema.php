<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class AuthorSchema extends Schema
{
    protected $type = 'author';

    public function getAttributes($resource)
    {
        return [
            'name'   => $resource->name,
            'job'    => $resource->position,
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
