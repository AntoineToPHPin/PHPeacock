<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL select clause.
 */
trait LimitClause
{
    /**
     * Limit clause length.
     * @var int $limitLength
     */
    protected int $limitLength;

    /**
     * Limit clause offset.
     * @var int|null $limitOffset
     */
    protected ?int $limitOffset;

    /**
     * Adds the limit clause.
     * 
     * @param int      $length Limit length.
     * @param int|null $offset Limit offset.
     * 
     * @return self
     */
    public function limit(int $length, ?int $offset = null): self
    {
        $this->limitLength = $length;
        $this->limitOffset = $offset;

        return $this;
    }
}
