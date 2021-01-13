<?php

namespace Cuongmits\GdprApi\Provider;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

interface SetProviderInterface
{
    public function get(GdprGetRequestData $requestData): array;
}
