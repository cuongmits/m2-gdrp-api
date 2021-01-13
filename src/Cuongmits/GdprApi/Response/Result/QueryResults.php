<?php

namespace Cuongmits\GdprApi\Response\Result;

use Component\Functor\NotNullFilter;
use JsonSerializable;

class QueryResults implements JsonSerializable
{
    public const KEY_FIRSTNAME = 'first_name';
    public const KEY_LASTNAME = 'last_name';
    public const KEY_EMAIL = 'email_address';
    public const KEY_DEBITOR_NUMBER = 'debitor_number';
    public const KEY_LOYALTY_CARD_NUMBER = 'debitor_card_number';

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    /** @var string */
    private $email;

    /** @var string */
    private $sapDebitorNumber;

    /** @var string */
    private $loyaltyCardNumber;

    public static function create(
        string $firstname = null,
        string $lastname = null,
        string $email = null,
        string $sapDebitorNumber = null,
        string $loyaltyCardNumber = null
    ): self {
        return new self($firstname, $lastname, $email, $sapDebitorNumber, $loyaltyCardNumber);
    }

    public function jsonSerialize()
    {
        return array_filter([
            self::KEY_FIRSTNAME => $this->firstname,
            self::KEY_LASTNAME => $this->lastname,
            self::KEY_EMAIL => $this->email,
            self::KEY_DEBITOR_NUMBER => $this->sapDebitorNumber,
            self::KEY_LOYALTY_CARD_NUMBER => $this->loyaltyCardNumber,
        ], new NotNullFilter());
    }

    private function __construct(
        string $firstname = null,
        string $lastname = null,
        string $email = null,
        string $sapDebitorNumber = null,
        string $loyaltyCardNumber = null
    ) {
        $this->sapDebitorNumber = $sapDebitorNumber;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->loyaltyCardNumber = $loyaltyCardNumber;
    }
}
