<?php

namespace bfy\Atlassian\Curl;

/**
 * Class AbstractAtlassianCurl
 * Common function for calling Atlassian API
 */
abstract class AbstractAtlassianCurl implements AtlassianCurlInterface
{
    private string $apiToken;

    public function __construct()
    {
        $this->apiToken = base64_encode(getenv('ATLASSIAN_EMAIL').':'.getenv('ATLASSIAN_API_KEY'));
    }

    protected abstract function prepareRequest();
    protected abstract function sendRequest();
    protected abstract function readResponse();

    public function getData()
    {
        $this->prepareRequest();
        $this->sendRequest();
        return $this->readResponse();
    }

    protected function initCurl()
    {
        $curlVersion = curl_version()['version'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic $this->apiToken",
            'Content-Type: application/json; charset=utf-8',
            "User-Agent: $curlVersion"
        ]);

        return $ch;
    }
}
