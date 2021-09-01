<?php
namespace PHPeacock\Framework\Persistence\Queries;

use PHPeacock\Framework\Exceptions\Persistence\Queries\SetClauseException;
use PHPeacock\Framework\Exceptions\Persistence\Queries\UpdateClauseException;

/**
 * SQL update queries builder.
 */
class UpdateQuery implements SQLQuery
{
    use UpdateClause,
        SetClause,
        WhereClause,
        BindParameter;

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!isset($this->updateTable))
        {
            throw new UpdateClauseException(message: 'The update clause is missing.');
        }

        if (isset($this->changes))
        {
            $changes = implode(separator: ', ', array: $this->changes);
        }
        else
        {
            throw new SetClauseException(message: 'The set clause is missing.');
        }

        $conditions = '';
        if (isset($this->conditions))
        {
            $conditions = 'WHERE ' . implode(separator: ' AND ', array: $this->conditions);
        }

        return trim(string: <<<SQL
UPDATE $this->updateTable
SET $changes
$conditions
SQL);
    }
}
