<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL order by clause.
 */
trait OrderByClause
{
    /**
     * Fields to order by.
     * @var int $limitLength
     */
    protected array $order;

    /**
     * Adds the fields to order by.
     * 
     * @param string $field Field to order by.
     * @param string $order Field order.
     * 
     * @return self
     */
    public function orderBy(string $field, string $order = 'ASC'): self
    {
        $this->order[] = $field . ' ' . $order;

        return $this;
    }
} 
