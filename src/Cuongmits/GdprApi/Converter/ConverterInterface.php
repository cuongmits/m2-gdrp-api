<?php

namespace Cuongmits\GdprApi\Converter;

interface ConverterInterface
{
    public function convert(array $plainQocArray): array;
}
