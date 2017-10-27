<?php

namespace Sarbinski\JsonApi\Schemas;

use Core;
use Sarbinski\JsonApi\Pact\Schema;

class PresentationSchema extends Schema
{
    protected $type = 'slides';

    public function getAttributes($resource)
    {

        return [
            'order'      => $resource->sort,
            'title'      => $resource->header,
            'subtitle'   => $resource->summary,
            'link'       => $resource->cta,
            'background' => $this->getBackground($resource),
            'we-are'     => $this->getWeAre($resource),
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

    private function getBackground($resource)
    {
        $background      = $resource->background()->first();
        $backgrounds     = [];
        $needAlternative = false;

        switch ($background->type) {
            case 'canvas':
                $needAlternative = true;

                $backgrounds[] = [
                    'platform'  => 'desktop',
                    'type'      => 'canvas',
                    'url'       => Core\Config()->urls('full')
                        . '/api/slides/getbackground/' . $resource->background_id,
                    'is-darker' => $background->color_scheme == 'dark' ? true : false,
                ];

                break;
            case 'video':
                $videos = [];

                foreach ($background->video as $format => $videoElement) {
                    if ($videoElement['file']) {
                        $needAlternative = true;
                        $videos[]        = [
                            'url'  => $background->getFileManagerAttachment($format),
                            'type' => (($format != 'poster') ? 'video/' : '') . $format,
                        ];
                    }
                }

                $backgrounds[] = [
                    'platform'  => 'desktop',
                    'type'      => 'video',
                    'sources'   => $videos,
                    'is-darker' => $background->color_scheme == 'dark' ? true : false,
                ];
                break;
            case 'photo':
                $backgrounds[] = [
                    'platform'  => 'desktop',
                    'type'      => 'image',
                    'url'       => $background->getAttachment('photo'),
                    'is-darker' => $background->color_scheme == 'dark' ? true : false,
                ];
                $needAlternative = true;

                break;
            case 'gif':
                $backgrounds[] = [
                    'platform'  => 'desktop',
                    'type'      => 'animation',
                    'color'     => $background->color,
                    'url'       => $background->getAttachment('photo'),
                    'is-darker' => $background->color_scheme == 'dark' ? true : false,
                ];
                break;
        }

        if ($needAlternative && $background->photo) {
            $backgrounds[] = [
                'platform'  => 'mobile',
                'type'      => 'image',
                'url'       => $background->getAttachment('photo', 'mobile'),
                'is-darker' => $background->color_scheme == 'dark' ? true : false,
            ];

            $backgrounds[] = [
                'platform'  => 'tablet',
                'type'      => 'image',
                'url'       => $background->getAttachment('photo', 'tablet'),
                'is-darker' => $background->color_scheme == 'dark' ? true : false,
            ];
        }

        return $backgrounds;
    }

    private function getWeAre($resource)
    {
        $weAre = [];
        foreach ($resource->dynamic_text as $platform => $text) {
            if ($text) {
                $weAre[] = [
                    'platform' => $platform,
                    'name'     => $text,
                ];
            }
        }

        return $weAre;
    }
}
