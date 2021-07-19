<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL select queries builder.
 */
class SelectQuery implements SQLQuery
{
    use SelectClause,
        FromClause,
        JoinClause,
        WhereClause,
        OrderByClause,
        LimitClause,
        BindParameter;

    /**
     * @return string
     */
    public function __toString(): string
    {
        $fields = implode(separator: ', ', array: $this->fields);

        $tables = implode(separator: ', ', array: $this->tables);

        $joins = '';
        if (isset($this->joins))
        {
            $joins = implode(separator: PHP_EOL, array: $this->joins);
        }
        
        $conditions = '';
        if (isset($this->conditions))
        {
            $conditions = 'WHERE ' . implode(separator: ' AND ', array: $this->conditions);
        }

        $orderBy = '';
        if (isset($this->order))
        {
            $orderBy = 'ORDER BY ' . implode(separator: ', ', array: $this->order);
        }

        $limit = '';
        if (isset($this->limitLength))
        {
            $limit = 'LIMIT ' . $this->limitLength;
            if (isset($this->limitOffset))
            {
                $limit .= ' OFFSET ' . $this->limitOffset;
            }
        }

        $selectQuery = trim(string: <<<SQL
SELECT $fields
FROM $tables
$joins
$conditions
$orderBy
$limit
SQL);

        // Removes the empty lines.
        $count = 0;
        do
        {
            $selectQuery = str_replace(
                search: PHP_EOL . PHP_EOL,
                replace: PHP_EOL,
                subject: $selectQuery,
                count: $count
            );
        } while ($count > 0);

        return $selectQuery;
    }
}