<?php

namespace bfy\Atlassian\Model;

use bfy\Model\Delivery;
use JsonSerializable;

/**
 * Class WikiPostRequest
 * Representative class of a request to post a wiki
 */
class WikiPostRequest implements JsonSerializable
{
    private string $title;
    private string $type = 'page';
    private string $content;
    private string $space;
    private string $parent;

    public function __construct(Delivery $bl)
    {
        $this->space = getenv('CONFLUENCE_TARGET_SPACE');
        $this->parent = getenv('CONFLUENCE_TARGET_ANCESTOR');

        $this->title = $bl->getTitle();
        $this->content = $bl->__toString();
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'type'  => $this->type,
            'body'  => [ 
                'storage' => [ 
                    'value' => $this->content,
                    'representation' => 'storage'
                ]
            ],
            'space' => [ 'key' => $this->space ],
            'ancestors' => [ 
                [ 'id' => $this->parent ]
            ]
        ];
    }
}
