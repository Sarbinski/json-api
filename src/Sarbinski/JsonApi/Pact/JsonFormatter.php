<?php

namespace Sarbinski\JsonApi\Pact;

use Sarbinski\JsonApi\Factories;

abstract class JsonFormatter
{
    /**
     *
     * @var \Sarbinski\JsonApi\Pact\Schema
     */
    protected $schemaClass;

    abstract public function build($resource);

    public function __construct($schemaClass)
    {
        $this->schemaClass = Factories\Factory::createSchema($schemaClass);
    }
}
