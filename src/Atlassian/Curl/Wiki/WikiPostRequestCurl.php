<?php

namespace bfy\Atlassian\Curl\Wiki;

use bfy\Atlassian\Curl\AbstractAtlassianCurl;

/**
 * Class WikiPostRequestCurl
 * Representative and functional class
 * for posting a wiki
 */
class WikiPostRequestCurl extends AbstractAtlassianCurl
{
    /** @var string  */
    private $payload;

    /** @var resource */
    private $ch;

    private $result;

    public function __construct($payload)
    {
        parent::__construct();
        $this->payload = json_encode($payload);
    }

    protected function prepareRequest()
    {
        $this->ch = $this->initCurl();
        curl_setopt($this->ch, CURLOPT_URL, getenv('CONFLUENCE_API_URL'));
        curl_setopt($this->ch, CURLOPT_POST, true);
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
