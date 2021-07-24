<?php

namespace bfy\Atlassian\Model;

/**
 * Class IssueGetResponse
 * Representative class of a response of an issue
 */
class IssueGetResponse
{
    private string $key;
    private string $title;
    private array $dependsOn = [];
    private array $labels = [];

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey($key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function addDependsOn(string $key, string $dependOn): self
    {
        $this->dependsOn[$key] = $dependOn;

        return $this;
    }

    public function getDependsOn(): array
    {
        return $this->dependsOn;
    }

    public function addLabel(string $label): self
    {
        $this->labels[] = $label;

        return $this;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }
}
