<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class QuoteSchema extends Schema
{
    protected $type = 'quote-content';

    public function getAttributes($resource)
    {
        return [
            'order'     => $resource->sort,
            'content'   => $resource->content->text,
            'source'    => $resource->content->source,
            'is-darker' => $resource->content->tint == 'dark' ? true : false,
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
