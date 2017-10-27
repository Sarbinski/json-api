<?php

namespace Sarbinski\JsonApi\Schemas;

use Core;
use Sarbinski\JsonApi\Pact\Schema;

class VideoSchema extends Schema
{
    protected $type = 'video-content';

    public function getAttributes($resource)
    {
        $baseUrl = Core\Config()->urls('full');

        $videos = [];
        $poster = null;
        if (is_array($resource->content->videos)) {
            foreach ($resource->content->videos as $format => $videoElement) {
                if ($videoElement['file']) {
                    if ($format == 'poster') {
                        $poster = $resource
                            ->attachmentsStorageUrl('content') . $videoElement['file'];
                    } else {
                        $videos[] = [
                            'url'  => $baseUrl . $resource
                                ->fileManagerStorageUrl('content') . $videoElement['file'],
                            'type' => (($format != 'poster') ? 'video/' : '') . $format,
                        ];
                    }
                }
            }
        }

        return [
            'order'      => $resource->sort,
            'caption'    => $resource->content->caption,
            'poster'     => $poster,
            'full-width' => (bool)$resource->content->full_width,
            'sources'    => $videos,
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
