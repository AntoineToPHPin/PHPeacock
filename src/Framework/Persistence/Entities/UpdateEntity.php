<?php
namespace PHPeacock\Framework\Persistence\Entities;

/**
 * Makes the entity have the `update` method.
 */
interface UpdateEntity
{
    /**
     * Updates the entity in the database.
     * 
     * @throws UpdateEntityException if an error occurs when updating an entity.
     * 
     * @return int Number of affected rows.
     */
    public function update(): int;
}
