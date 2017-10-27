<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class BulletsSchema extends Schema
{
    protected $type = 'bullets';

    public function getAttributes($resource)
    {
        return [
            'order'   => $resource->sort,
            'title'   => $resource->content->title,
            'caption' => $resource->content->caption,
            'bullets' => $this->getBullets($resource),
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

    private function getBullets($resource)
    {
        $bullets = [];
        foreach ($resource->content->bullets as $bullet) {
            $bullets[] = $bullet['title'];
        }

        return $bullets;
    }
}
