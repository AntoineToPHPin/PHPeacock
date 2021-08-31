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
     * @throws InsertEntityException if an error occurs when inserting an entity.
     * 
     * @return int Number of affected rows.
     */
    public function insert(): int;
}
