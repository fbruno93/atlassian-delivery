<?php

namespace bfy\Atlassian\Transformer;

/**
 * Class AbstractDataTransformerObject
 * common functionality of dto
 */
abstract class AbstractDataTransformerObject implements DataTransformerObjectInterface
{
    public function transformArray(iterable $datas): array
    {
        $objects = [];

        foreach ($datas as $data) {
            $objects[] = $this->transform($data);
        }

        return $objects;
    }
}
