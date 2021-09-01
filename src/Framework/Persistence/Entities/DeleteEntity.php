<?php
namespace PHPeacock\Framework\Persistence\Entities;

/**
 * Makes the entity have the `delete` method.
 */
interface DeleteEntity
{
    /**
     * Deletes the entity from the database.
     * 
     * @throws DeleteEntityException if an error occurs when deleting an entity.
     * 
     * @return int Number of affected rows.
     */
    public function delete(): int;
}
