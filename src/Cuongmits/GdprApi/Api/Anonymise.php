<?php

namespace Cuongmits\GdprApi\Api;

class Anonymise implements AnonymiseGdprDataInterface
{
    public function anonymise(string $firstname, string $lastname, string $email, string $debitorNumber, string $loyaltyNumber): bool
    {
        return true;
    }
}
