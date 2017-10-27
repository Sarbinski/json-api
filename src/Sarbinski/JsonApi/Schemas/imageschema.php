<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class ImageSchema extends Schema
{
    protected $type = 'image-content';

    public function getAttributes($resource)
    {
        return [
            'order'      => $resource->sort,
            'path'       => $resource->content->getAttachment(),
            'full-width' => (bool)$resource->content->full_width,
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
