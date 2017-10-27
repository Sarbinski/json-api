<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class OfficesInclSchema extends SillaSchema
{
    protected $type = 'offices';

    public function getAttributes($resource)
    {
        return [
            'has-openings' => (bool)$resource->positions()
                                ->select('COUNT(id) as num')->first()->num,
            'name'         => $resource->name,
            'name-short'   => $resource->title,
            'slug'         => $resource->slug,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $this->buildRelationArray($resource->images()->all(), 'images', 'photos');
        $this->buildRelationArray($resource->positions()->all(), 'careers', 'careers');

        return $this->relations;
    }
}
