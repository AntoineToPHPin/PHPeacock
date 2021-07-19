<?php
namespace PHPeacock\Framework\Persistence\Entities;

use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

abstract class SelectEntity
{
    protected DBMSConnection $dbmsConnection;

    abstract public function selectById(int $id): Entity;

    abstract public function selectAll(): EntityCollection;

    abstract public function selectWithLimit(int $length, ?int $offset = null): EntityCollection;
}
