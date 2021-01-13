<?php

namespace Cuongmits\GdprApi\Filter;

class RemoveNullValueItemFilter
{
    public function apply(array $arr): array
    {
        return array_filter($arr, function ($item) {
            return !is_null($item['value']);
        });
    }
}
