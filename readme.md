# Atlassian delivery

## Prerequisite
- Atlassian account
- Atlassian A.P.I. Token. [Here](https://id.atlassian.com/manage-profile/security/api-tokens) to create one

## Setup 
- Edit ``.env`` file (or create ``.env.local``)
```dotenv
AUTHOR="Your NAME"

ATLASSIAN_API_KEY=PREVIOUSLY-API-TOKEN-CREATED
ATLASSIAN_EMAIL=atlassian-login@email.com

CONFLUENCE_TARGET_LIST=summary-page-id
CONFLUENCE_TARGET_SPACE=space-id
CONFLUENCE_TARGET_ANCESTOR=parent-page-id
```

Where to find theses informations ?
``CONFLUENCE_TARGET_LIST`` Go to the page listing all delivery. The url look like : 
``https://{domain}.atlassian.net/wiki/spaces/{spaceId}/pages/{pageId}/Livraison+BL+test``

So copy ``{spaceId}`` value and paste for key ``CONFLUENCE_TARGET_SPACE`` 
and copy ``{pageId}`` value and paste for key ``CONFLUENCE_TARGET_LIST`` and ``CONFLUENCE_TARGET_ANCESTOR``

## Usage
```shell
usage: php main.php

Examples:
    php main.php --jira="TCK-123 KCT-321" --sf1="x.y.z"

Generate an delivery into Confluence from Jira information

Required options:
    -j --jira       list of jira identifier [required]

At least one required:
    -1 --sf1        sf1 version will be deliver
    -a --sf4api     sf4 api version will be deliver
    -f --sf4front   sf4 front version will be deliver

Optional:
    -s --summary    push edited summary confluence page [default: false]

Debug options: when it is set, no documents push to atlassian services
    -d --debug      show software delivery (markdown format) [default: false]
```
