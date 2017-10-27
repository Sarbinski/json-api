<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class EmployeesSchema extends SillaSchema
{
    protected $type = 'employees';

    public function getAttributes($resource)
    {
        return [
            'order'        => (int)$resource->sort,
            'image'        => $resource->getAttachment('media', 'main'),
            'name'         => $resource->name,
            'position'     => $resource->position,
            'global'       => (bool)$resource->global,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $this->buildRelationArray($resource->office()->all(), 'offices', 'offices');

        return $this->relations;
    }
}
