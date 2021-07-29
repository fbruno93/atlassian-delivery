<?php

namespace bfy;

/**
 * Class Options
 * Helper for script options
 */
class Options
{
    private array $options;

    public function __construct()
    {
        $this->options = getopt('j:1::a::f::s::h::d::', [
            'jira:', 'sf1::', 'sf4a::', 'sf4::', 'summary::', 'help::', 'debug::'
        ]);
    }

    /*
     * MANDATORY OPTIONS
     */

    public function getJiras(): array
    {
        $jiras = $this->options['jira'] ?? $this->options['j'] ?? '';

        return explode(' ', $jiras);
    }

    /*
     * CONTEXTUAL MANDATORY OPTION
     */

    public function getSf1(): ?string
    {
        return $this->options['sf1'] ?? $this->options['1'] ?? null;
    }

    public function getSf4api(): ?string
    {
        return $this->options['sf4api'] ?? $this->options['a'] ??null;
    }

    public function getSf4front(): ?string
    {
        return $this->options['sf4front'] ?? $this->options['f'] ?? null;
    }

    /*
     * OPTIONAL OPTIONS
     */

    public function doEditSummary(): bool
    {
        //isset($this->options['summary']) || isset($this->options['s']);
        return false;
    }

    public function askHelp(): bool
    {
        return isset($this->options['help']) || isset($this->options['h']);
    }

    public function isDebug(): bool
    {
        return isset($this->options['debug']) || isset($this->options['d']);
    }

    /*
     * HELPER FUNCTIONS
     */

    public function isValid(): bool
    {
        if (!$this->getJiras() ||
            !$this->getSf1() && !$this->getSf4api() && !$this->getSf4front()
        ) {
            return false;
        }

        return true;
    }

    /**
     * Help string
     *
     * Keep string identical of readme.md
     *
     * @return string
     */
    public function help(): string
    {
        return 'usage: php main.php 

Examples: 
    Minimal:    php main.php --jira="TCK-1 TCK-2" --sf1="x.y.z"
    Debug:      php main.php --jira="TCK-1 TCK-2" --sf1="x.y.z" --debug
    
Generate a delivery into Confluence from Jira information

Required options:
    -j --jira       list of jira identifier [required]

At least one required:
    -1 --sf1        sf1 version will be deliver
    -a --sf4api     sf4 api version will be deliver
    -f --sf4front   sf4 front version will be deliver

Optional:
    -s --summary    push edited summary confluence page
    -h --help       show this help

Debug options: when it is set, no documents push to atlassian services
    -d --debug      show software delivery (markdown format) [default: false]
';
    }
}
