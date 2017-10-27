<?php

namespace Sarbinski\JsonApi\DataObjects;

class ErrorObject
{
    private $id;
    private $link;
    private $source = [];
    private $meta   = [];
    private $status;
    private $code;
    private $title;
    private $detail;

    public function getId()
    {
        return $this->id;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDetail()
    {
        return $this->detail;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    public function setPointer($pointer)
    {
        $this->source['pointer'] = $pointer;
    }

    public function setParameter($parameter)
    {
        $this->source['parameter'] = $parameter;
    }
}
