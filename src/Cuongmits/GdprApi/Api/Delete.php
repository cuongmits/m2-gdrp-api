<?php

namespace Cuongmits\GdprApi\Api;

class Delete implements DeleteGdprDataInterface
{
    public function delete(string $firstname, string $lastname, string $email, string $debitorNumber, string $loyaltyNumber): bool
    {
        return true;
    }
}
