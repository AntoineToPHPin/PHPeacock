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
     * @return void
     */
    public function delete(): void;
}
