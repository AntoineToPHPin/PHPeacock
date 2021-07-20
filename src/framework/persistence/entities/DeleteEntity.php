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
     * @return void
     */
    public function delete(): void;
}
