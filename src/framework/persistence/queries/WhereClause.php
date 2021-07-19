<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL where clause.
 */
trait WhereClause
{
    /**
     * Query conditions.
     * @var array $conditions
     */
    protected array $conditions;

    /**
     * Adds a condition to the query.
     * 
     * @param string $condition Condition to add.
     * 
     * @return self
     */
    public function where(string $condition): self
    {
        $this->conditions[] = $condition;

        return $this;
    }
}
