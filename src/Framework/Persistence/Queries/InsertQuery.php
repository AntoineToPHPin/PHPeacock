<?php
namespace PHPeacock\Framework\Persistence\Queries;

use PHPeacock\Framework\Exceptions\Persistence\Queries\InsertClauseException;
use PHPeacock\Framework\Exceptions\Persistence\Queries\ValuesClauseException;

/**
 * SQL insert queries builder.
 */
class InsertQuery implements SQLQuery
{
    use InsertClause,
        ValuesClause,
        BindParameter;

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!isset($this->insertTable))
        {
            throw new InsertClauseException(message: 'The insert clause is missing.');
        }

        if (!isset($this->values))
        {
            throw new ValuesClauseException(message: 'The values clause is missing.');
        }

        $fields = array_keys(array: $this->values);
        $insert = $this->insertTable . ' (' . implode(separator: ', ', array: $fields) . ')';
        $values = '(' . implode(separator: ', ', array: $this->values) . ')';

        return trim(string: <<<SQL
INSERT INTO $insert
VALUES $values
SQL);
    }
}
