<?php

namespace Sarbinski\JsonApi\Formatter;

use Sarbinski\JsonApi\Pact\JsonFormatter;
use Sarbinski\JsonApi\Factories;

class DataFormatter extends JsonFormatter
{
    /**
     * Required data elements
     */
    const ID   = 'id';
    const TYPE = 'type';

    /**
     *  Not required data elements
     */
    const ATTRIBUTES    = 'attributes';
    const RELATIONSHIPS = 'relationships';
    const LINKS         = 'links';
    const META          = 'meta';

    private $meta          = [];
    private $links         = [];
    private $attributes    = [];
    private $relationships = [];

    public function getItemId($resource)
    {
        return $this->schemaClass->getId($resource);
    }

    public function getItemType($resource)
    {
        return $this->schemaClass->getType($resource);
    }

    public function build($resources, $skipRelations = false)
    {
        $elements = [];

        if (!is_array($resources) && !is_a($resources, '\Traversable')) {
            $this->attributes = $this->getAttributes($resources);
            $elements         = [
                self::TYPE => $this->getItemType($resources),
                self::ID   => $this->getItemId($resources),
            ];

            if (count($this->attributes) > 0) {
                $elements[self::ATTRIBUTES] = $this->attributes;
                $this->getRelationships($resources, $skipRelations);
            }

            if ($this->relationships !== false) {
                $elements[self::RELATIONSHIPS] = $this->relationships;
            }

            if ($this->links) {
                $elements[self::LINKS] = $this->links;
            }

            if ($this->meta) {
                $elements[self::META] = $this->meta;
            }
        } else {
            $iterator = 0;
            foreach ($resources as $item) {
                $this->attributes = $this->getAttributes($item);

                $elements[$iterator] = [
                    self::TYPE => $this->getItemType($item),
                    self::ID   => $this->getItemId($item),
                ];

                if (count($this->attributes) > 0) {
                    $this->getRelationships($item, $skipRelations);
                    $elements[$iterator][self::ATTRIBUTES] = $this->attributes;
                }

                if ($this->relationships !== false) {
                    $elements[$iterator][self::RELATIONSHIPS] = $this->relationships;
                }

                if ($this->links) {
                    $elements[$iterator][self::LINKS] = $this->links;
                }

                if ($this->meta) {
                    $elements[$iterator][self::META] = $this->meta;
                }

                $iterator++;
            }
        }

        return $elements;
    }

    public function getAttributes($resource)
    {
        return $this->schemaClass->getAttributes($resource);
    }

    public function getRelationships($resource, $skip = false)
    {
        if ($skip) {
            $this->relationships = false;
            return;
        }

        $relationFormatter = Factories\Factory::createRelationshipsFormatter(
                get_class($this->schemaClass));

        $this->relationships = $relationFormatter->build($resource);
    }

    public function getLinks()
    {
    }

    public function getMeta()
    {
    }
}
