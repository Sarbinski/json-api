<?php

namespace Sarbinski\JsonApi\Factories;

use Sarbinski\JsonApi\DataObjects;
use Sarbinski\JsonApi\Formatter\DataFormatter;
use Sarbinski\JsonApi\Formatter\ErrorFormatter;
use Sarbinski\JsonApi\Formatter\LinksFormatter;
use Sarbinski\JsonApi\Formatter\RelationshipsFormatter;

class Factory
{
    public static function createDataFormatter($schemaClass)
    {
        return new DataFormatter($schemaClass);
    }

    public static function createRelationshipsFormatter($schemaClass)
    {
        return new RelationshipsFormatter($schemaClass);
    }

    public static function createErrorFormatter($schemaClass)
    {
        return new ErrorFormatter($schemaClass);
    }

    public static function createLinksFormatter($schemaClass)
    {
        return new LinksFormatter($schemaClass);
    }

    /**
     *
     * @param string $schemaClass
     * @return \Sarbinski\JsonApi\Pact\Schema
     * @throws \InvalidArgumentException
     */
    public static function createSchema($schemaClass)
    {
        $class = new \ReflectionClass($schemaClass);

        if (!$class->isSubclassOf('Sarbinski\JsonApi\Pact\Schema')) {
            throw new \InvalidArgumentException(
            "\$resourceClass ({$schemaClass}) must implements Schema Class");
        }

        return $class->newInstance();
    }

    public static function createRelationshipObject($objectName, &$data)
    {
        return new DataObjects\RelationshipObject($objectName, $data);
    }

    public static function createLinkObject($objectName, &$data)
    {
        return new DataObjects\LinkObject($objectName, $data);
    }
}