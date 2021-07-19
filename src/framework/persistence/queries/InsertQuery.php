<?php
namespace PHPeacock\Framework\Persistence\Queries;

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
        $fields = array_keys(array: $this->values);
        $insert = $this->insertTable . ' (' . implode(separator: ', ', array: $fields) . ')';
        $values = '(' . implode(separator: ', ', array: $this->values) . ')';

        return trim(string: <<<SQL
INSERT INTO $insert
VALUES $values
SQL);
    }
}
