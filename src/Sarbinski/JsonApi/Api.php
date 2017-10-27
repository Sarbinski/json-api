<?php

namespace Sarbinski\JsonApi;

use Sarbinski\JsonApi\Factories\Factory;

class Api
{
    /*TODO Provide headers */

    /**
     * Main JSON API objects
     */
    const DATA     = 'data';
    const META     = 'meta';
    const LINKS    = 'links';
    const ERRORS   = 'errors';
    const INCLUDED = 'included';

    private $printData = [];
    private $data      = [];
    private $included  = false;
    private $errors;
    private $links = [];
    private $meta = [];
    private $dataAddedFlag = false;

    public function __construct()
    {
    }

    public function registerSchemaAutoloader($pathToSchemaDir, $prefix = '')
    {
        // PSR-4 Example autoloader :)
        spl_autoload_register(function ($class) use ($pathToSchemaDir, $prefix) {
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                // no, move to the next registered autoloader
                return;
            }

            $relative_class = substr($class, $len);

            $file = $pathToSchemaDir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

    public function createData($resources, $schemaClass, $skipRelations = false)
    {
        $this->dataAddedFlag = true;
        $dataFormatter = Factory::createDataFormatter($schemaClass);
        $data          = $dataFormatter->build($resources, $skipRelations);
        $this->data    = array_merge($this->data, $data);
        
        return $data;
    }

    public function buildMainJSONStructure()
    {
        if ($this->errors) {
            $this->printData[self::ERRORS] = $this->errors;
            // TODO throw error...
            // JSON-API standart - "data" and "errors" MUST NOT coexist in the same document.
            return;
        }

        if ($this->meta) {
            $this->printData[self::META] = $this->meta;
        }

        if ($this->dataAddedFlag) {
            $this->printData[self::DATA] = $this->data;
        }

        if ($this->data && $this->included) {
            $this->printData[self::INCLUDED] = $this->included;
        }

        if (($this->data || $this->errors || $this->meta) && $this->links) {
            $this->printData[self::LINKS] = $this->links;
        }

        return $this;
    }

    public function getPrintData($jsonEncoded = false)
    {
        if ($jsonEncoded) {
            return json_encode($this->printData,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return $this->printData;
    }

    /**
     * <b>WARNING!</b> Calling this function will clear all previous compiled data
     *  with <b>createData()</b> method.
     * @param array $newData
     */
    public function setData(array $newData)
    {
        $this->data = $newData;
    }

    public function createError($resources, $schemaClass)
    {
        $errorFormatter = Factory::createErrorFormatter($schemaClass);
        $this->errors = $errorFormatter->build($resources);
    }

    public function createLinks($resources, $schemaClass)
    {
        $linksFormatter = Factory::createLinksFormatter($schemaClass);
        $this->links = array_merge($this->links, $linksFormatter->build($resources));
    }

    public function createMeta($metName, $metaValue)
    {
        $this->meta[$metName] = $metaValue;
    }

    public function createIncluded($schemaClass, $resources, $skipRelation = true)
    {
        $dataFormatter  = Factory::createDataFormatter($schemaClass);

        if (is_array($this->included)) {
            $this->included = array_merge($this->included, $dataFormatter->build($resources, $skipRelation));
        } else {
            $this->included = $dataFormatter->build($resources, $skipRelation);
        }
    }
}