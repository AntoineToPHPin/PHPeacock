<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL join clause.
 */
trait JoinClause
{
    /**
     * Liste of joins.
     * @var array $joins
     */
    protected array $joins;

    /**
     * Adds a join clause.
     * 
     * @param string      $type      Join type.
     * @param string      $table     Join table.
     * @param string      $condition Join condition.
     * @param string|null $alias     Table alias.
     * 
     * @return self
     */
    public function join(string $type, string $table, string $condition, ?string $alias = null): self
    {
        $this->joins[] = strtoupper(string: $type) . ' JOIN ' . $table . (isset($alias) ? ' ' . $alias : '') . ' ON ' . $condition;

        return $this;
    }
}
