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
     * @return void
     */
    public function update(): void;
}
