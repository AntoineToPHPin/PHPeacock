<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL delete clause.
 */
trait DeleteClause
{
    /**
     * Table to delete.
     * @var string $deleteTable
     */
    protected string $deleteTable;

    /**
     * Adds a table to delete.
     * 
     * @param string $table Table to delete.
     * 
     * @return self
     */
    public function delete(string $table): self
    {
        $this->deleteTable = $table;

        return $this;
    }
}
