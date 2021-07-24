<?php

namespace bfy\Atlassian\Curl\Wiki;

use bfy\Atlassian\Curl\AbstractAtlassianCurl;
use bfy\Atlassian\Model\WikiGetResponse;

class WikiPutRequestCurl extends AbstractAtlassianCurl
{
    private const PARAM = '?expand=body.storage';

    /** @var string  */
    private $payload;

    /** @var resource */
    private $ch;

    private $result;

    private $id;

    public function __construct(WikiGetResponse $payload)
    {
        parent::__construct();
        $this->payload = json_encode($payload);
        $this->id = $payload->getId();
    }

    protected function prepareRequest()
    {
        $this->ch = $this->initCurl();
        curl_setopt($this->ch, CURLOPT_URL, getenv('CONFLUENCE_API_URL').$this->id.self::PARAM);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->payload);
    }

    protected function sendRequest()
    {
        $this->result = curl_exec($this->ch);
    }

    protected function readResponse(): string
    {
        $resp = json_decode($this->result, true);
        $urlWebUi = $resp['_links']['webui'];

        // Remove first "/"
        $path = ltrim($urlWebUi, $urlWebUi[0]);
        return getenv('CONFLUENCE_WEB_URL').$path;
    }

    public function getData(): string
    {
        return parent::getData();
    }
}
