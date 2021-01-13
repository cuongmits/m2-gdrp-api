<?php

namespace Cuongmits\GdprApi\Model;

class Pagination
{
    /** @var int */
    private $totalSize;

    /** @var int */
    private $pageSize;

    /** @var int */
    private $cursor;

    public static function create(int $totalSize, int $pageSize, int $cursor = 0): self
    {
        return new self($totalSize, $pageSize, $cursor);
    }

    /**
     * @return int|null
     */
    public function getNextCursor(): ?int
    {
        $nextCursor = $this->cursor + $this->pageSize;
        return $nextCursor < $this->totalSize ? $nextCursor : null;
    }

    /**
     * @return int|null
     */
    public function getPreviousCursor(): ?int
    {
        return ($this->cursor > 0) ? max($this->cursor - $this->pageSize, 0) : null;
    }

    /**
     * @return int
     */
    public function getCurrentSize(): int
    {
        return min($this->totalSize - $this->cursor, $this->pageSize);
    }

    /**
     * @return int
     */
    public function getCursor(): int
    {
        return $this->cursor;
    }

    /**
     * @return int
     */
    public function getTotalSize(): int
    {
        return $this->totalSize;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    private function __construct(int $totalSize, int $pageSize, int $cursor = 0)
    {
        $this->totalSize = $totalSize;
        $this->pageSize = $pageSize;
        $this->cursor = $cursor;
    }
}
