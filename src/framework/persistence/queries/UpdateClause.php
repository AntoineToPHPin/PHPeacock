<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL update clause.
 */
trait UpdateClause
{
    /**
     * Table to update.
     * @var string $updateTable
     */
    protected string $updateTable;

    /**
     * Adds a table to update.
     * 
     * @param string $table Table to update.
     * 
     * @return self
     */
    public function update(string $table): self
    {
        $this->updateTable = $table;

        return $this;
    }
}
