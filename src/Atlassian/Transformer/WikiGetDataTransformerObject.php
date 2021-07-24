<?php

namespace bfy\Atlassian\Transformer;

use bfy\Atlassian\Model\WikiGetResponse;

class WikiGetDataTransformerObject extends AbstractDataTransformerObject
{
    public function transform($data): WikiGetResponse
    {
        $content = "<root>{$data['body']['storage']['value']}</root>";

        $confluence = new WikiGetResponse();
        $confluence->setId($data['id']);
        $confluence->setTitle($data['title']);
        $confluence->setVersion($data['version']['number']);
        $confluence->setType($data['type']);
        $confluence->setContent($content);

        return $confluence;
    }
}
