<?php

namespace Sarbinski\JsonApi\Schemas;

use Core;
use Sarbinski\JsonApi\Pact\Schema;
use Sarbinski\JsonApi\DataObjects;
use CMS\Models;

class WorkListingSchema extends Schema
{
    protected $type = 'projects';

    public function getAttributes($resource)
    {
        return [
            'order'    => $this->addOrdering(),
            'title'    => $resource->title,
            'slug'     => $resource->slug,
            'images'   => $this->getImages($resource),
        ];
    }

    public function getId($resource)
    {
        return $resource->id;
    }

    public function getLinks($link)
    {
        $linksData[$link['name']] = Core\Router()->toFullUrl(array(
            'controller' => 'works',
            'page' => array('number' => $link['number'], 'size' => $link['size'])));

        return $linksData;
    }

    public function getRelationships($resource)
    {
        $relations = null;

        $client_id = $resource->client_id;
        $client    = Models\Client::find()->where('id = ' . (int)$client_id)->first();

        if ($client) {
            $data = [
                'id'   => $client->id,
                'type' => 'client'
            ];

            $relations[] = new DataObjects\RelationshipObject('client', $data);
        }

        if ($resource->work_types()->all()) {
            $work_type_data = [];

            foreach($resource->work_types()->all() as $type) {
                $work_type_data[] = [
                    'id'   => $type->id,
                    'slug' => $type->slug,
                    'type' => 'category'
                ];
            }
	        $relations[] = new DataObjects\RelationshipObject('category', $work_type_data);
        }

        return $relations;
    }

    private function getImages($resource)
    {
        $images = [];

        for ($ii = 1; $ii < 5; $ii++) {
            $image = 'image_' . $ii;
            if ($resource->{$image}) {
                $images[] = $resource->getAttachment($image);
            }
        }

        return $images;
    }
}
