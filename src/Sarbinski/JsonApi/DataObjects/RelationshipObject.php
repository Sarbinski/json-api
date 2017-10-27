<?php

namespace Sarbinski\JsonApi\DataObjects;

class RelationshipObject
{
    private $relationName;
    private $data  = [];
    private $links = [];
    private $meta  = [];

    public function __construct($name, array $data, array $links = [], array $meta = [])
    {
        $this->relationName = $name;
        $this->data         = $data;
        $this->links        = $links;
        $this->meta         = $meta;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getName()
    {
        return $this->relationName;
    }
}
