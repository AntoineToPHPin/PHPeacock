<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * Makes every SQL query builder stringable.
 * 
 * The query builders __toString method must return
 * a correct SQL query.
 */
interface SQLQuery extends \Stringable
{ }
