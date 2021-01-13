<?php

namespace Cuongmits\GdprApi\Response;

use Component\Functor\NotNullFilter;
use JsonSerializable;
use Cuongmits\GdprApi\Model\Pagination as PaginationModel;

class Pagination implements JsonSerializable
{
    public const KEY_CURSOR = 'cursor';
    public const KEY_CURSOR_PREVIOUS = 'prev';
    public const KEY_CURSOR_CURRENT = 'current';
    public const KEY_CURSOR_NEXT = 'next';
    public const KEY_LIMIT = 'limit';
    public const KEY_RESULT_SIZE = 'size';

    /** @var PaginationModel */
    private $paginationModel;

    /**
     * @param PaginationModel $paginationModel
     *
     * @return static
     */
    public static function create(PaginationModel $paginationModel): self
    {
        return new self($paginationModel);
    }

    public function jsonSerialize()
    {
        return [
            self::KEY_CURSOR => array_filter([
                self::KEY_CURSOR_PREVIOUS => $this->paginationModel->getPreviousCursor(),
                self::KEY_CURSOR_CURRENT => $this->paginationModel->getCursor(),
                self::KEY_CURSOR_NEXT => $this->paginationModel->getNextCursor(),
            ], new NotNullFilter()),
            self::KEY_LIMIT => $this->paginationModel->getPageSize(),
            self::KEY_RESULT_SIZE => $this->paginationModel->getCurrentSize(),
        ];
    }

    private function __construct(PaginationModel $paginationModel)
    {
        $this->paginationModel = $paginationModel;
    }
}
