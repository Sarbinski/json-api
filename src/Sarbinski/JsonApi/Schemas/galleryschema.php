<?php

namespace Sarbinski\JsonApi\Schemas;

use Core;
use Sarbinski\JsonApi\Pact\Schema;

class GallerySchema extends Schema
{
    protected $type = 'gallery-content';

    public function getAttributes($resource)
    {
        $images = [];
        if (is_array($resource->content->images)) {
            foreach ($resource->content->images as $key => $image) {
//                $images[] = $resource->attachmentsStorageUrl('content') . $image['value'];
                $images[] = [
                    'desktop' => $resource->content->getAttachment($key),
                    'mobile' => $resource->content->getAttachment($key, 'mobile'),
                ];
            }
        }

        return [
            'order'      => $resource->sort,
            'full-width' => $resource->content->full_width === 'true',
            'images'     => $images,
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
