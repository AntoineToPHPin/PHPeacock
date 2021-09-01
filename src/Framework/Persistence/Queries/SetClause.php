<?php
namespace PHPeacock\Framework\Persistence\Queries;

/**
 * SQL set clause.
 */
trait SetClause
{
    /**
     * Fields to set.
     * @var array $changes
     */
    protected array $changes;

    /**
     * Adds a field to set with its new value.
     * 
     * @param string $field Field to set.
     * @param mixed  $value Field value.
     * 
     * @return self
     */
    public function set(string $field, mixed $value): self
    {
        $this->changes[] = $field . ' = ' . $value;

        return $this;
    }
}
