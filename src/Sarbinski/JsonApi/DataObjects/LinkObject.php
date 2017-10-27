<?php

namespace Sarbinski\JsonApi\DataObjects;

class LinkObject
{
    const HREF  = 'href';
    const SELF  = 'self';
    const META  = 'meta';

    private $data;
    private $name;

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function getHref()
    {
        if (!is_array($this->data)) {
            return $this->data;
        }

        $linkObject = [];
        !isset($this->data[self::HREF]) ?: $linkObject[self::HREF] = $this->data[self::HREF];
        !isset($this->data[self::SELF]) ?: $linkObject[self::SELF] = $this->data[self::SELF];
        !isset($this->data[self::META]) ?: $linkObject[self::META] = $this->data[self::META];

        return $linkObject;
    }

    public function getName()
    {
        return $this->name;
    }
}
