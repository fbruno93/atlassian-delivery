<?php

namespace bfy;

use bfy\Atlassian\Curl\Issue\GetIssuesRequest;
use bfy\Atlassian\Curl\Wiki\WikiGetCurl;
use bfy\Atlassian\Curl\Wiki\WikiPostRequestCurl;
use bfy\Atlassian\Curl\Wiki\WikiPutRequestCurl;
use bfy\Atlassian\Model\WikiGetResponse;
use bfy\Atlassian\Model\WikiPostRequest;
use bfy\Helper\DOMHelper;
use bfy\Model\Delivery;
use bfy\Model\ScriptResponse;

class MainController
{
    private const RETURN_OK = 0;

    private string $author;

    private string $confluenceTargetList;

    public function __construct()
    {
        $this->author = getenv('AUTHOR');
        $this->confluenceTargetList = getenv('CONFLUENCE_TARGET_LIST');
    }

    public function start(Options $options): ScriptResponse
    {
        $delivery = $this->getDeliveryFromIssues($options);

        if ($options->isDebug()) {
            return new ScriptResponse(self::RETURN_OK, $delivery);
        }

        $webUrlDelivery = $this->postDeliveryOnWiki($delivery);
        $successPostDelivery = "Delivery created. See on $webUrlDelivery\n";

        if (!$options->doEditSummary()) {
            return new ScriptResponse(self::RETURN_OK, $successPostDelivery);
        }

        $summary = $this->getSummaryOfDeliveries();

        // Add delivery meta to summary
        DOMHelper::addRowToSummary($summary->getContent(), $delivery->getTitle(), $delivery->getNotes(), $webUrlDelivery);

        $webUrlSummary = $this->saveSummary($summary);

        $successSaveSummary = "Summary updated. See on ". $webUrlSummary."\n";

        return new ScriptResponse(self::RETURN_OK, $successPostDelivery.$successSaveSummary);
    }

    private function getDeliveryFromIssues(Options $options): Delivery
    {
        $tickets = (new GetIssuesRequest($options->getJiras()))->getData();

        $delivery = Delivery::buildDelivery($options->isDebug());
        $delivery->setAuthor($this->author);
        $delivery->setTickets($tickets);
        $delivery->setVersions([
            'sf1' => $options->getSf1(),
            'sf4api' => $options->getSf4Api(),
            'sf4front' => $options->getSf4Front()
        ]);

        return $delivery;
    }

    private function postDeliveryOnWiki(Delivery $delivery): string
    {
        $wikiPostRequest = new WikiPostRequest($delivery);

        $webUrlBl = (new WikiPostRequestCurl($wikiPostRequest))
            ->getData();

        return $webUrlBl;
    }

    private function getSummaryOfDeliveries(): WikiGetResponse
    {
        return (new WikiGetCurl($this->confluenceTargetList))
            ->getData();
    }

    private function saveSummary($summary): string
    {
        return (new WikiPutRequestCurl($summary))
            ->getData();
    }
}