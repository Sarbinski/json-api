<?php

namespace Sarbinski\JsonApi\Schemas;

use Core;

class JobsListingSchema extends SillaSchema
{
    protected $type = 'careers';

    public function getAttributes($resource)
    {
        $data = [
            'title'   => $resource->title,
            'content' => $resource->content,
            'summary' => $resource->summary,
        ];

        if ($resource->internal) {
            $data['url'] = Core\Config()->urls('full') . 'careers/' . $resource->slug;
        } else {
            $data['url'] = $resource->url;
        }

        return $data;
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $this->buildRelationArray($resource->office()->all(), 'offices', 'offices');

        return $this->relations;
    }
}
