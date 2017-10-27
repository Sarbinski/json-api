<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class FooterSchema extends Schema
{
    protected $type = 'footer-presentations';

    public function getAttributes($resource)
    {
        return [
            'we-are'     => $this->weAre($resource),
            'background' => $this->background($resource),
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

    private function weAre($resource)
    {
        $weAre = [];
        foreach ($resource->dynamic_text as $platform => $text) {
            if ($text) {
                array_push($weAre, [
                    'platform' => $platform,
                    'name'     => $text,
                ]);
            }
        }

        return $weAre;
    }

    private function background($resource)
    {
        return  [
            [
                'platform'  => 'desktop',
                'is-darker' => $resource->media_tint == 'dark' ? true : false,
                'url'       => $resource->getAttachment('media'),
            ],
            [
                'platform'  => 'mobile',
                'is-darker' => $resource->media_tint == 'dark' ? true : false,
                'url'       => $resource->getAttachment('media', 'mobile'),
            ],
            [
                'platform'  => 'tablet',
                'is-darker' => $resource->media_tint == 'dark' ? true : false,
                'url'       => $resource->getAttachment('media', 'tablet'),
            ],
        ];
    }
}
