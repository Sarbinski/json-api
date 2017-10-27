<?php

namespace Sarbinski\JsonApi\Schemas;

use Sarbinski\JsonApi\Pact\Schema;

class GridArticlesSchema extends Schema
{
    protected $type = 'gridlist-content';

    public function getAttributes($resource)
    {
        $articles = [];
        if (is_array($resource->content->articles)) {
            foreach ($resource->content->articles as $key => $article) {
                $articles[$key]['order']   = (string)(isset($article['sort'])
                    ? $article['sort'] : 1);
                $articles[$key]['image']   =
                    $resource->attachmentsStorageUrl('content') . $article['thumb'];
                $articles[$key]['title']   = $article['title'];
                $articles[$key]['content'] = $article['description'];
            }
        }

        return [
            'order'    => $resource->sort,
            'title'    => $resource->content->title,
            'subtitle' => $resource->content->subtitle,
            'summary'  => $resource->content->summary,
            'items'    => $articles,
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
