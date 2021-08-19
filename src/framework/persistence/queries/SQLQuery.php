<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * Makes every SQL query builder stringable.
 */
interface SQLQuery extends \Stringable
{
    /**
     * Returns a correct SQL query.
     * 
     * @throws QueryException if an error occurs when building a query.
     * 
     * @return string
     */
    public function __toString(): string;
}
