<?php

namespace Sarbinski\JsonApi\Formatter;

use Sarbinski\JsonApi\Pact\JsonFormatter;

class ErrorFormatter extends JsonFormatter
{
    const ID     = 'id';
    const LINKS  = 'links';
    const STATUS = 'status';
    const CODE   = 'code';
    const TITLE  = 'title';
    const DETAIL = 'detail';
    const SOURCE = 'source';
    const META   = 'meta';

    public function build($resource)
    {
        $stdElements = new \stdClass();

        $id     = $resource->getId();
        $title  = $resource->getTitle();
        $status = $resource->getStatus();
        $detail = $resource->getDetail();
        $link   = $resource->getLink();
        $meta   = $resource->getMeta();
        $source = $resource->getSource();
        $code   = $resource->getCode();

        if ($id) {
            $stdElements->{self::ID} = $id;
        }

        if ($status) {
            $stdElements->{self::STATUS} = $status;
        }

        if ($detail) {
            $stdElements->{self::DETAIL} = $detail;
        }

        if ($title) {
            $stdElements->{self::TITLE} = $title;
        }

        if ($link) {
            $stdElements->{self::LINKS} = $link;
        }

        if ($meta) {
            $stdElements->{self::META} = $meta;
        }

        if ($source) {
            $stdElements->{self::SOURCE} = $source;
        }

        if ($code) {
            $stdElements->{self::CODE} = $code;
        }

        return $stdElements;
    }
}
