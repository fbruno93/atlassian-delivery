<?php

namespace bfy\Atlassian\Model;

use DOMDocument;
use JsonSerializable;

class WikiGetResponse implements JsonSerializable
{
    private string $id;
    private string $title;
    private string $version;
    private string $type;
    private DOMDocument $content;

    public function __construct()
    {
        $this->content = new DOMDocument();
        $this->content->strictErrorChecking = false;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getContent(): DOMDocument
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content->loadXML($content);
    }

    public function jsonSerialize(): array
    {
        return [
            'version' => [ 'number' => ++$this->version ],
            'status' => 'current',
            'title' => $this->title,
            'type' => 'page',
            'body' => [
                'storage' => [
                    'value' => $this->content->saveHTML(),
                    'representation' => 'editor'
                ]
            ]
        ];
    }
}
