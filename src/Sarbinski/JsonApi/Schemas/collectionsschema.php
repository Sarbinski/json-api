<?php

namespace Sarbinski\JsonApi\Schemas;

class CollectionsSchema extends SillaSchema
{
    protected $type = 'collections';

    public function getAttributes($resource)
    {
        return [
            'order'        => $this->addOrdering(),
            'title'        => $resource->collection_name,
            'slug'         => $resource->slug,
            'tag-title'    => $resource->title,
            'image'        => $resource->getAttachment('media'),
            'image-mobile' => $resource->getAttachment('media', 'mobile'),
            'image-thumb'  => $resource->getAttachment('media', 'thumb'),
            'color-scheme' => $resource->media_tint,
            'summary'      => $resource->summary,
            'number'       => $resource->collection_number,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $articles = $resource->articles()
            ->where('is_active = 1')
            ->all();
        $this->buildRelationArray($articles, 'posts', 'ideas');

        return $this->relations;
    }
}
