<?php

namespace Cuongmits\GdprApi\Model;

class GdprGetRequestData
{
    /** @var null|string */
    private $firstname;

    /** @var null|string */
    private $lastname;

    /** @var null|string */
    private $sapDebitor;

    /** @var null|string */
    private $email;

    /** @var null|string */
    private $loyaltyCardNumber;

    /** @var int */
    private $limit;

    /** @var int */
    private $cursor;

    public function __construct(
        ?string $firstname,
        ?string $lastname,
        ?string $email,
        ?string $sapDebitor,
        ?string $loyaltyCardNumber,
        int $limit,
        int $cursor
    ) {
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->sapDebitor = $sapDebitor;
        $this->loyaltyCardNumber = $loyaltyCardNumber;
        $this->limit = $limit;
        $this->cursor = $cursor;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getSapDebitor(): ?string
    {
        return $this->sapDebitor;
    }

    public function getLoyaltyCardNumber(): ?string
    {
        return $this->loyaltyCardNumber;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getCursor(): int
    {
        return $this->cursor;
    }
}
