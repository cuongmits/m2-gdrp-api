<?php

namespace Cuongmits\GdprApi\Provider;

use Magento\Framework\App\Request\Http;

class ParametersProvider
{
    public const DEFAULT_LIMIT = 100;
    public const DEFAULT_CURSOR = 0;

    /** @var Http */
    private $request;

    public function __construct(Http $request)
    {
        $this->request = $request;
    }

    public function getFirstname(): ?string
    {
        return $this->request->getParam('first_name');
    }

    public function getLastname(): ?string
    {
        return $this->request->getParam('last_name');
    }

    public function getEmail(): ?string
    {
        return $this->request->getParam('email_address');
    }

    public function getDebitorNumber(): ?string
    {
        return $this->request->getParam('debitor_number');
    }

    public function getLoyaltyNumber(): ?string
    {
        return $this->request->getParam('debitor_card_number');
    }

    public function getLimit(): int
    {
        $limit = $this->request->getParam('limit');

        return (empty($limit) || (int) $limit < 1) ? self::DEFAULT_LIMIT : (int) $limit;
    }

    public function getCursor(): int
    {
        $cursor = $this->request->getParam('cursor');

        return (empty($cursor) || (int) $cursor < 0) ? self::DEFAULT_CURSOR : (int) $cursor;
    }
}
