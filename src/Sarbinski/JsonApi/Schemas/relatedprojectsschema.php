<?php

namespace Sarbinski\JsonApi\Schemas;

class RelatedProjectsSchema extends SillaSchema
{
    protected $type = 'posts';

    public function getAttributes($resource)
    {
        $publishedTime = new \DateTime($resource->publish_on);
        $publishedDate = $publishedTime->format('M j, Y');

        return [
            'slug'      => $resource->slug,
            'date'      => $publishedDate,
            'title'     => $resource->title,
            'subtitle'  => $resource->subtitle,
            'thumbnail' => $resource->getAttachment('photo', 'related'),
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $tags     = $resource->tags()->all();

        if ($tags) {
            $this->buildRelationArray($tags, 'collections', 'tags');
            return $this->relations;
        }

        return false;
    }
}
