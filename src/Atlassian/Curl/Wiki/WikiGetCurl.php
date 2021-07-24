<?php

namespace bfy\Atlassian\Curl\Wiki;

use bfy\Atlassian\Curl\AbstractAtlassianCurl;
use bfy\Atlassian\Model\WikiGetResponse;
use bfy\Atlassian\Transformer\WikiGetDataTransformerObject;

class WikiGetCurl extends AbstractAtlassianCurl
{
    private const PARAM = '?expand=body.storage,version.number,title,type';
    private string $id;

    private array $result;
    private $ch;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    protected function prepareRequest()
    {
        $this->ch = $this->initCurl();
        curl_setopt($this->ch, CURLOPT_URL, getenv('CONFLUENCE_API_URL').$this->id.self::PARAM);
    }

    protected function sendRequest()
    {
        $this->result = json_decode(curl_exec($this->ch), true);
    }

    protected function readResponse(): WikiGetResponse
    {
        return (new WikiGetDataTransformerObject())->transform($this->result);
    }

    public function getData(): WikiGetResponse
    {
        return parent::getData();
    }
}
