<?php
namespace PHPeacock\Framework\Persistence\Queries;

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
        $changes = implode(', ', $this->changes);

        $conditions = '';
        if (isset($this->conditions))
        {
            $conditions = 'WHERE ' . implode(' AND ', $this->conditions);
        }

        return trim(string: <<<SQL
UPDATE $this->updateTable
SET $changes
$conditions
SQL);
    }
}
