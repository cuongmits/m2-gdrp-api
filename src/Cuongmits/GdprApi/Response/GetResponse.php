<?php

namespace Cuongmits\GdprApi\Response;

use JsonSerializable;

class GetResponse implements JsonSerializable
{
    public const KEY_LABEL = 'label';
    public const KEY_DESCRIPTION = 'description';
    public const KEY_PAGINATION = 'page';
    public const KEY_QUERY = 'query';
    public const KEY_RESULTS = 'results';

    /** @var Pagination */
    private $pagination;

    /** @var array */
    private $originalQuery;

    /** @var array|JsonSerializable[] */
    private $results = [];

    /**
     * @param array      $originalQuery
     * @param Pagination $pagination
     * @param Result[]   $results
     *
     * @return static
     */
    public static function create(array $originalQuery, Pagination $pagination, array $results): self
    {
        return new self($originalQuery, $pagination, $results);
    }

    public function jsonSerialize()
    {
        return [
            self::KEY_LABEL => __('Shop customers'),
            self::KEY_DESCRIPTION => __('Order, cart and customer personal data from the toom M2 shop'),
            self::KEY_PAGINATION => $this->pagination->jsonSerialize(),
            self::KEY_QUERY => $this->originalQuery,
            self::KEY_RESULTS => $this->results,
        ];
    }

    private function __construct(array $originalQuery, Pagination $pagination, array $results)
    {
        $this->originalQuery = $originalQuery;
        $this->pagination = $pagination;
        $this->results = $results;
    }
}
