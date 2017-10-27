<?php

namespace Sarbinski\JsonApi\Formatter;

use Sarbinski\JsonApi\Pact\JsonFormatter;

class RelationshipsFormatter extends JsonFormatter
{
    const LINKS = 'links';
    const DATA  = 'data';
    const META  = 'meta';

    public function build($resource)
    {
        $relations = $this->schemaClass->getRelationships($resource);
        
        if (is_array($relations)) {
            if(empty($relations)) {
                return $relations;
            }
            
            $stdElements = new \stdClass();
            foreach ($relations as $relation) {
                $data  = $relation->getData();
                $links = $relation->getLinks();
                $meta  = $relation->getMeta();

                if (count($data) > 0) {
                    $stdElements->{$relation->getName()}[self::DATA] = $relation->getData();
                }

                if (count($links) > 0) {
                    $stdElements->{$relation->getName()}[self::LINKS] = $relation->getLinks();
                }

                if (count($meta) > 0) {
                    $stdElements->{$relation->getName()}[self::META] = $relation->getMeta();
                }

                //TODO if no one is provided-> throw Exception
            }

            return $stdElements;
        } elseif ($relations === null) {
            return null;
        }

        return false;
    }
}
