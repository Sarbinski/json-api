<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;
use Sarbinski\JsonApi\Factories;

class ModulesSchema extends Schema
{
    protected $type = 'posts';

    public function getAttributes($resource)
    {
        $schema = $this->getModuleSchema($resource->type);

        $moduleAttr = $schema->getAttributes($resource);
        $this->setType($schema->getType());

        return $moduleAttr;
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        return false;
    }

    /**
     * Return Schema object by type of module
     *
     * @param string $module
     * @return \Sarbinski\JsonApi\Pact\Schema
     */
    public function getModuleSchema($module)
    {
        $schemaObject = null;
        switch ($module) {
            case 'text':
                $schemaObject = 'TextSchema';
                break;
            case 'bullets':
                $schemaObject = 'BulletsSchema';
                break;
            case 'image':
                 $schemaObject = 'ImageSchema';
                break;
            case 'image-article':
                 $schemaObject = 'ImageArticleSchema';
                break;
            case 'grid-articles':
                 $schemaObject = 'GridArticlesSchema';
                break;
            case 'gallery':
                 $schemaObject = 'GallerySchema';
                break;
            case 'video':
                 $schemaObject = 'VideoSchema';
                break;
            case 'quote':
                 $schemaObject = 'QuoteSchema';
                break;
            case 'accent':
                 $schemaObject = 'AccentSchema';
                break;
            default:
                throw new \LogicException("Undefined Module type \"{$module}\" or module without Schema class is used! " . __FILE__);
        }

        return Factories\Factory
            ::createSchema(__NAMESPACE__ . '\\' . $schemaObject);
    }
}
