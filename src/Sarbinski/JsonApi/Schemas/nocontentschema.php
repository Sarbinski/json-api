<?php

namespace Sarbinski\JsonApi\Schemas;

class NoContentSchema extends SillaSchema
{
    protected $type = 'nocontent';

    public function getAttributes($resource)
    {
        return [
            'color'     => $resource->color,
            'url'       => $resource->getAttachment('media'),
            'is-darker' => $resource->color_scheme == 'dark' ? true : false,
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
