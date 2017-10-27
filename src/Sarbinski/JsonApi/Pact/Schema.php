<?php

namespace Sarbinski\JsonApi\Pact;

abstract class Schema
{
    protected $type;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getLinks($resource)
    {
    }

    protected function addOrdering()
    {
        static $counter = 1;

        return (string)$counter++;
    }

    /**
     *
     * @param mixed $resource
     * @return null|array  Must return one of following:
     *      Null for empty to-one relationships
     *      An empty array ([]) for empty to-many relationships
     *      An array with RelationshipObject objects
     */
    abstract public function getRelationships($resource);

    /**
     * Provide attributes
     *
     * @param mixed $resource
     * @return array Array with data attributes with key=>value format
     */
    abstract public function getAttributes($resource);

    abstract public function getId($resource);
}
