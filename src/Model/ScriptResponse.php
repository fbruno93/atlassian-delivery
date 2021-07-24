<?php

namespace bfy\Model;

class ScriptResponse
{
    private int $code;
    private string $output;

    public function __construct($code, $output)
    {
        $this->code = $code;
        $this->output = $output;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}