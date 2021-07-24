<?php

namespace bfy\Atlassian\Transformer;

/**
 * Interface DataTransformerObjectInterface
 * public functions of DTO
 */
interface DataTransformerObjectInterface
{
    public function transform($data);
    public function transformArray(iterable $datas): array;
}
