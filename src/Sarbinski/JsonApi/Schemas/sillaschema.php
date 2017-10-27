<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;
use Sarbinski\JsonApi\Factories\Factory;

abstract class SillaSchema extends Schema
{
    protected $relations = [];

    protected function buildRelationArray(array $data, $type, $relationName)
    {
        $relation = [];

        foreach ($data as $item) {
            array_push($relation, [
                'id'   => $item->id,
                'type' => $type
            ]);
        }

        $this->relations[] = Factory::createRelationshipObject($relationName, $relation);
    }
}
