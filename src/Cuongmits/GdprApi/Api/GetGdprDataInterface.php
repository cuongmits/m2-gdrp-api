<?php

namespace Cuongmits\GdprApi\Api;

use Cuongmits\Webapi\Api\Data\CustomServiceOutputInterface;

interface GetGdprDataInterface
{
    /**
     * Get GDPR Data
     *
     * @return CustomServiceOutputInterface
     */
    public function get(): CustomServiceOutputInterface;
}
