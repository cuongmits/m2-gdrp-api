<?php

namespace Cuongmits\GdprApi\Api;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\GetResultProvider;
use Cuongmits\GdprApi\Provider\ParametersProvider;
use Cuongmits\Webapi\Api\Data\CustomServiceOutputInterface;
use Cuongmits\Webapi\Model\CustomArrayOutput;
use Cuongmits\GdprApi\Validator\GetRequestValidator;
use Cuongmits\GdprApi\Validator\UniqueCustomerLimitValidator;

class Get implements GetGdprDataInterface
{
    public const RESPONSE_ERROR_KEY = 'error';
    public const RESPONSE_RECORD_NUMBER = 'record_number';

    /** @var GetResultProvider */
    private $getResultProvider;

    /** @var GetRequestValidator */
    private $getValidator;

    /** @var ParametersProvider */
    private $parametersProvider;

    /** @var UniqueCustomerLimitValidator */
    private $limitValidator;

    public function __construct(
        ParametersProvider $parametersProvider,
        GetResultProvider $getResultProvider,
        GetRequestValidator $getValidator,
        UniqueCustomerLimitValidator $limitValidator
    ) {
        $this->getResultProvider = $getResultProvider;
        $this->getValidator = $getValidator;
        $this->parametersProvider = $parametersProvider;
        $this->limitValidator = $limitValidator;
    }

    public function get(): CustomServiceOutputInterface
    {
        $requestData = new GdprGetRequestData(
            $this->parametersProvider->getFirstname(),
            $this->parametersProvider->getLastname(),
            $this->parametersProvider->getEmail(),
            $this->parametersProvider->getDebitorNumber(),
            $this->parametersProvider->getLoyaltyNumber(),
            $this->parametersProvider->getLimit(),
            $this->parametersProvider->getCursor()
        );

        $errorCode = $this->getValidator->getValidErrorCode($requestData);
        if ($errorCode) {
            return CustomArrayOutput::create([self::RESPONSE_ERROR_KEY => $errorCode]);
        }

        $result = $this->getResultProvider->get($requestData);

        return CustomArrayOutput::create($result);
    }
}
