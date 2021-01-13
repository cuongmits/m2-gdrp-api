<?php

namespace Cuongmits\GdprApi\Api;

interface AnonymiseGdprDataInterface
{
    /**
     * Anonymise GDPR Data
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $debitorNumber
     * @param string $loyaltyNumber
     *
     * @return bool
     */
    public function anonymise(string $firstname, string $lastname, string $email, string $debitorNumber, string $loyaltyNumber): bool;
}
