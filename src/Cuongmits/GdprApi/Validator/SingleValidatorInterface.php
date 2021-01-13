<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

interface SingleValidatorInterface
{
    public function isValid(GdprGetRequestData $requestData): bool;
}
