<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL delete queries builder.
 */
class DeleteQuery implements SQLQuery
{
    use DeleteClause,
        WhereClause,
        BindParameter;

    /**
     * @return string
     */
    public function __toString(): string
    {
        $conditions = '';
        if (isset($this->conditions))
        {
            $conditions = 'WHERE ' . implode(separator: ' AND ', array: $this->conditions);
        }

        return trim(string: <<<SQL
DELETE FROM $this->deleteTable
$conditions
SQL);
    }
}
