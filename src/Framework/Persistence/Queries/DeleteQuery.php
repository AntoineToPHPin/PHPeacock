<?php
namespace PHPeacock\Framework\Persistence\Queries;

use PHPeacock\Framework\Exceptions\Persistence\Queries\DeleteClauseException;

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
        if (!isset($this->deleteTable))
        {
            throw new DeleteClauseException(message: 'The delete clause is missing.');
        }

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
