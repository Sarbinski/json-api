<?php

namespace Sarbinski\JsonApi\DataObjects;

class DataObject
{
    private $data;

    public function __construct(array $data)
    {
        if (!isset($data['id']) || !isset($data['type'])) {
            throw new \InvalidArgumentException('Data Object MUST contain "id" and "type" keys!');
        }
        
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
