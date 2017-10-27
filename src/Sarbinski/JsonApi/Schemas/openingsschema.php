<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Factories\Factory;

class OpeningsSchema extends SillaSchema
{
    protected $type = 'careers';

    public function getAttributes($resource)
    {
        return [
            'order'   => $this->addOrdering(),
            'title'   => $resource->title,
            'url'     => $resource->url,
            'summary' => $resource->summary,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $relation = [
                'id'   => $resource->id,
                'type' => 'offices'
            ];

        $this->relations[] = Factory::createRelationshipObject('office', $relation);

        return $this->relations;
    }
}
