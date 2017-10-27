<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Factories\Factory;

class PostSchema extends SillaSchema
{
    protected $type = 'posts';

    public function getAttributes($resource)
    {
        $publishedTime = new \DateTime($resource->publish_on);
        $publishedDate = $publishedTime->format('M j, Y');

        $reflect = new \ReflectionClass($resource);
        $modelName = strtolower($reflect->getShortName());

        $data = [
            'type'         => $modelName,
            'title'        => $resource->title,
            'slug'         => $resource->slug,
            'subtitle'     => $resource->subtitle,
            'heading'      => $resource->summary,
            'cta_text'     => $resource->cta_text,
            'color-scheme' => $resource->media_tint,
            'date'         => $publishedDate,
        ];

        if ($resource->photo) {
            $data['image'] = $resource->getAttachment('photo');
            $data['image-mobile'] = $resource->getAttachment('photo', 'mobile');
        } elseif (is_array($resource->video) && count($resource->video) > 0) {
            $videos        = [];
            $data['image'] = null;

            foreach ($resource->video as $format => $vData) {
	            if ($format == 'poster' && $vData['file']) {
		            $data['poster'] = $resource
			            ->getFileManagerAttachment('video', $format);
	            } elseif ($vData['file']) {
                    $videos[] = [
                        'type' => $format,
                        'url'  => $resource
                            ->getFileManagerAttachment('video', $format),
                    ];
                }
            }

            $data['source'] = $videos;
        }

        return $data;
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getRelationships($resource)
    {
        $postModules = [];
        $modules     = $resource->activeModules();

        $modulesSchema = Factory
            ::createSchema('Sarbinski\JsonApi\Schemas\ModulesSchema');

        foreach ($modules as $module) {
            $modulSchem = $modulesSchema->getModuleSchema($module->type);

            array_push($postModules, [
                'id'   => $module->id,
                'type' => $modulSchem->getType(),
            ]);
        }

        $this->relations[] = Factory::createRelationshipObject('contents', $postModules);

        $tags     = $resource->tags()->all();
        $related  = $resource->related()->all();
        $employee = $resource->employee()->all();

        if ($tags) {
            $this->buildRelationArray($tags, 'collections', 'tags');
        }

        if ($related) {
            $this->buildRelationArray($related, 'posts', 'relateds');
        }

        if ($employee) {
            $this->buildRelationArray($employee, 'author', 'author');
        }

        return $this->relations;
    }
}
