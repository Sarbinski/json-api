<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class ContactQuestionsSchema extends Schema
{
    protected $type = 'contact-reasons';

    public function getAttributes($resource)
    {
        return [
            'title'  => $resource->question,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        return false;
    }
}
