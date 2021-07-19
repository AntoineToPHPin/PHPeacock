<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL insert clause.
 */
trait InsertClause
{
    /**
     * Table to insert.
     * @var string $insertTable
     */
    protected string $insertTable;

    /**
     * Adds a table to insert.
     * 
     * @param string $table Table to insert.
     * 
     * @return self
     */
    public function insert(string $table): self
    {
        $this->insertTable = $table;

        return $this;
    }
}
