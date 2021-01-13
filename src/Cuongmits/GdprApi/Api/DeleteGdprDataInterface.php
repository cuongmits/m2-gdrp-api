<?php

namespace Cuongmits\GdprApi\Api;

interface DeleteGdprDataInterface
{
    /**
     * Delete GDPR Data
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $debitorNumber
     * @param string $loyaltyNumber
     *
     * @return bool
     */
    public function delete(string $firstname, string $lastname, string $email, string $debitorNumber, string $loyaltyNumber): bool;
}
