<?php

namespace Cuongmits\GdprApi\Response;

use Component\Functor\NotNullFilter;
use JsonSerializable;
use Cuongmits\GdprApi\Response\Result\QueryResults;

class Result implements JsonSerializable
{
    public const KEY_DATA = 'data';
    public const KEY_QUERY_RESULTS = 'query_results';
    public const KEY_DELETE_ENDPOINTS = 'delete_endpoints';
    public const KEY_ANONYMIZE_ENDPOINTS = 'anonymize_endpoints';

    /** @var array */
    private $data = [];

    /** @var QueryResults */
    private $queryResults;

    /**
     * @param array        $data
     * @param QueryResults $queryResults
     *
     * @return static
     */
    public static function create(array $data, QueryResults $queryResults): self
    {
        return new self($data, $queryResults);
    }

    public function jsonSerialize()
    {
        return [
            self::KEY_DATA => $this->data,
            self::KEY_QUERY_RESULTS => $this->queryResults,
            self::KEY_DELETE_ENDPOINTS => [],
            self::KEY_ANONYMIZE_ENDPOINTS => [],
        ];
    }

    private function __construct(
        array $data,
        QueryResults $queryResults
    ) {
        $this->data = $data;
        $this->queryResults = $queryResults;
    }
}
