<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL select clause.
 */
trait SelectClause
{
    /**
     * Fields to select.
     * @var array $fields
     */
    protected array $fields;

    /**
     * Adds a field to select, with alias if necessary.
     * 
     * @param string      $field Field to select.
     * @param string|null $alias Field alias.
     * 
     * @return self
     */
    public function select(string $field, ?string $alias = null): self
    {
        $this->fields[] = $field . (isset($alias) ? ' AS ' . $alias : '');

        return $this;
    }
}
