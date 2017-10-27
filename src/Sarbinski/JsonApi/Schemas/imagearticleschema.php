<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class ImageArticleSchema extends Schema
{
    protected $type = 'imagetext-content';

    public function getAttributes($resource)
    {
        return [
            'order'      => $resource->sort,
            'path'       => $resource->content->getAttachment(),
            'align'      => $resource->content->article['align'],
            'title'      => $resource->content->article['title'],
            'subtitle'   => $resource->content->article['subtitle'],
            'background' => $resource->content->article['background'],
            'content'    => $resource->content->article['description'],
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
