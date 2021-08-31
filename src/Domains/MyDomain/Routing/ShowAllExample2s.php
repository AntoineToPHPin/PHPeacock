<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample2;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * “Show all example2s” action.
 */
class ShowAllExample2s extends Example2Action
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample2 = new SelectExample2(dbmsConnection: $this->dbmsConnection);

        $allExample2s = $selectExample2->selectAll();

        foreach ($allExample2s as $example2)
        {
            echo '<p>field1 : ' . $example2->getField1() . ', example field1 : ' . $example2->getExample()->getField1() .
            ', example field2 : ' . $example2->getExample()->getField2() . '.';
        }
    }
}
