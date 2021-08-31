<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL values clause.
 */
trait ValuesClause
{
    /**
     * Values to insert.
     * @var array $values
     */
    protected array $values;

    /**
     * Adds a value to insert.
     * 
     * @param string $field Field to add value to it.
     * @param mixed  $value Value to add.
     * 
     * @return self
     */
    public function values(string $field, mixed $value): self
    {
        $this->values[$field] = $value;

        return $this;
    }
}
