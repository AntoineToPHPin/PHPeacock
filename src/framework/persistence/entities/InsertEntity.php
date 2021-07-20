<?php
namespace PHPeacock\Framework\Persistence\Entities;

/**
 * Makes the entity have the `insert` method.
 */
interface InsertEntity
{
    /**
     * Inserts the entity into the database.
     * 
     * @return void
     */
    public function insert(): void;
}
