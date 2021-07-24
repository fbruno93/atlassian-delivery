<?php

namespace bfy\Atlassian\Transformer;

use bfy\Atlassian\Model\IssueGetResponse;

/**
 * Class IssueGetDataTransformerObject
 * specific dto for getting issue
 */
class IssueGetDataTransformerObject extends AbstractDataTransformerObject
{
    private $blockType = '';

    private $labelsAvailable = [
        'SF1',
        'SF4FRONT',
        'SF4API',
        'SF1BO'
    ];

    public function __construct($blockType = "QEXP")
    {
        $this->blockType = $blockType;
    }

    public function transform($data): IssueGetResponse
    {
        $jira = new IssueGetResponse();
        $jira->setKey($data['key']);
        $jira->setTitle($data['fields']['summary']);
        $reg = "/{$this->blockType}-[\d]+/";

        foreach($data['fields']['issuelinks'] as $issue) {
            if (isset($issue['inwardIssue']) && preg_match($reg, $issue['inwardIssue']['key'])) {
                $jira->addDependsOn($issue['inwardIssue']['key'], $issue['inwardIssue']['fields']['summary']);
            }

            if (isset($issue['outwardIssue']) && preg_match($reg, $issue['outwardIssue']['key'])) {
                $jira->addDependsOn($issue['outwardIssue']['key'], $issue['outwardIssue']['fields']['summary']);
            }
        }

        foreach($data['fields']['labels'] as $label) {
            if (!in_array($label, $this->labelsAvailable)) {
                continue;
            }

            $jira->addLabel($label);
        }

        return $jira;
    }
}
