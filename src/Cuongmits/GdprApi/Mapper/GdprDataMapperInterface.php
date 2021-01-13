<?php

namespace Cuongmits\GdprApi\Mapper;

interface GdprDataMapperInterface
{
    public function map(?int $customerId): array;
    public function load(array $customerIds): void;
}
