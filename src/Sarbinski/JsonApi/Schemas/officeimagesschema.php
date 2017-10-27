<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class OfficeImagesSchema extends Schema
{
    protected $type = 'images';

    public function getAttributes($resource)
    {
        return [
            'name' => $resource->title,
            'path' => $resource->getAttachment('media', 'scaled'),
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
