<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class TestSchema extends Schema
{
    protected $type = 'test-schema';

    public function getAttributes($resource)
    {
        return [
            'name' => $resource['id'] . '_' . $resource['name'],
        ];
    }

    public function getId($resource)
    {
        return $resource['id'];
    }

    public function getRelationships($resource)
    {
        return false;
    }
}
