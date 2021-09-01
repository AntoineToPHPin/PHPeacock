<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL from clause.
 */
trait FromClause
{
    /**
     * Tables to list.
     * @var array $tables
     */
    protected array $tables;

    /**
     * Adds a table to list, with alias if necessary.
     * 
     * @param string      $table Table to list.
     * @param string|null $alias Table alias.
     * 
     * @return self
     */
    public function from(string $table, ?string $alias = null): self
    {
        $this->tables[] = $table . (isset($alias) ? ' ' . $alias : '');

        return $this;
    }
}
