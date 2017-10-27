<?php

namespace Sarbinski\JsonApi\Schemas;

class IdeasListingSchema extends SillaSchema
{
    protected $type = 'posts';

    public function getAttributes($resource)
    {
        $publishedTime = new \DateTime($resource->publish_on);
        $publishedDate = $publishedTime->format('M j, Y');
        $videos = [];

        $data = [
            'type'       => 'idea',
            'order'        => $this->addOrdering(),
            'title'      => $resource->title,
            'slug'       => $resource->slug,
            'date'       => $publishedDate,
        ];

        foreach ($resource->listing as $name => $media) {
            if ($name == 'poster' && $media['file']) {
                $data['poster'] = $resource
                    ->getFileManagerAttachment('listing', $name);
            } elseif ($media['file']) {
                $videos[] = [
                    'url'  => $resource
                        ->getFileManagerAttachment('listing', $name),
                    'type' =>  'video/' . $name,
                ];
            }
        }

        if (!isset($data['poster'])) {
            $data['poster'] = '';
        }

        $data['source'] = $videos;

        return $data;
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $tags = $resource->tags()->all();

        if ($tags) {
            $this->buildRelationArray($tags, 'collections', 'tags');
        }

        return $this->relations;
    }
}
