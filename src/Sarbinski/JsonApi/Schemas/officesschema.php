<?php

namespace Sarbinski\JsonApi\Schemas;

class OfficesSchema extends SillaSchema
{
    protected $type = 'offices';

    public function getAttributes($resource)
    {
        return [
            'order'        => $this->addOrdering(),
            'has-openings' => (bool)$resource->positions()
                                ->select('COUNT(id) as num')->first()->num,
            'name'         => $resource->name,
            'name-short'   => $resource->title,
            'color-scheme' => $resource->media_tint,
            'slug'         => $resource->slug,
            'phone'        => $resource->phone,
            'image'        => $resource->getAttachment('media'),
            'image-mobile' => $resource->getAttachment('media', 'mobile'),
            'image-thumb'  => $resource->getAttachment('media', 'thumb'),
            'address'      => $resource->address,
            'geo'          => $resource->geo,
            'title'        => $resource->description,
            'summary'      => $resource->interesting,
            'info'         => $resource->info,
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $this->buildRelationArray($resource->images()->all(), 'images', 'photos');
        $this->buildRelationArray($resource->positions()->all(), 'careers', 'careers');

        return $this->relations;
    }
}
