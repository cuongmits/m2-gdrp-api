<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

interface RequestValidatorInterface
{
    public function getValidErrorCode(GdprGetRequestData $requestData): int;
}
