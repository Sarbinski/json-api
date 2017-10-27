<?php

namespace Sarbinski\JsonApi\Formatter;

use Sarbinski\JsonApi\Pact\JsonFormatter;

class LinksFormatter extends JsonFormatter
{
    public function build($resource)
    {
        $links = $this->schemaClass->getLinks($resource);
        
        if (!is_array($links) || empty($links)) {
            throw new \InvalidArgumentException("getLinks() method shoud return not empty array!");
        }

        if (isset($links[0]) && is_a($links[0], 'Sarbinski\JsonApi\DataObjects\LinkObject')) {
            $stdElements = new \stdClass();

            foreach ($links as $link) {
                $stdElements->{$link->getName()} = $link->getHref();
            }

            return $stdElements;
        }

        return $links;
    }
}
