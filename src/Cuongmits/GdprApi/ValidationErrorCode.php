<?php

namespace Cuongmits\GdprApi;

final class ValidationErrorCode
{
    public const VALID = 0;
    public const INVALID_ALL_EMPTY_INPUTS = 1;
    public const INVALID_ONE_EMPTY_NAME = 2;
    public const INVALID_FIRSTNAME = 3;
    public const INVALID_LASTNAME = 4;
    public const INVALID_FULLNAME = 5;
    public const INVALID_EMAIL = 6;
    public const INVALID_LOYALTY_CARD_PREFIX = 7;
    public const INVALID_LOYALTY_CARD_LENGTH = 8;
    public const INVALID_RESPONSE_LIMIT = 9;
}
