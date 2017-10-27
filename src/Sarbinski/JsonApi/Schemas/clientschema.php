<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class ClientSchema extends Schema
{
    protected $type = 'client';

    public function getAttributes($resource)
    {
        return [
            'name' => $resource->title,
            'logo' => $resource->getAttachment('media'),
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
