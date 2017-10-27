<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;
use Sarbinski\JsonApi\Factories\Factory;

class PageSchema extends Schema
{
    protected $type = 'menu';

    public function getAttributes($resource)
    {
        $videos = [];

        $data = [
            'order'             => $this->addOrdering(),
            'title'             => $resource->title,
            'extra-title'       => $resource->extra_title,
            'extra-title-small' => $resource->extra_title_small,
            'summary'           => $resource->summary,
            'slug'              => $resource->slug,
            'cta-text'          => $resource->cta_text,
            'position'          => $resource->position,
            'is-visible'        => (bool) $resource->is_active,
        ];

        if ($resource->video) {
            foreach ($resource->video as $name => $media) {
                if ($name == 'poster' && $media['file']) {
                    $data['poster'] = $resource
                        ->getFileManagerAttachment('video', $name);
                } elseif ($media['file']) {
                    $videos[] = [
                        'url'  => $resource
                            ->getFileManagerAttachment('video', $name),
                        'type' => 'video/' . $name,
                    ];
                }

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
        $relation = [];
        $footer   = [];

        array_push($footer, [
            'id'   => $resource->id,
            'type' => 'footer-presentations',
        ]);

        $relation[] = Factory::createRelationshipObject('footer', $footer);

        return $relation;
    }

    private function getVideos($resource)
    {
        $videos = [];

        if ($resource->video) {
            foreach ($resource->video as $name => $media) {
//                if(!$media['file']) {
//                    continue;
//                }
//
//                $type = $name;
//                if ($name != 'poster') {
//                    $type = 'video/' . $name;
//                }
//
//                $videos[] = [
//                    'url'  => $resource
//                        ->getFileManagerAttachment('video', $name),
//                    'type' =>  $type,
//                ];
                if ($name == 'poster' && $media['file']) {
                    $data['poster'] = $resource
                        ->getFileManagerAttachment('video', $name);
                } elseif ($media['file']) {
                    $videos[] = [
                        'url'  => $resource
                            ->getFileManagerAttachment('video', $name),
                        'type' => 'video/' . $name,
                    ];
                }

                if (!isset($data['poster'])) {
                    $data['poster'] = '';
                }

                $data['source'] = $videos;
            }
        }

        return $videos;
    }
}
