<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample2;
use PHPeacock\Framework\Persistence\Connections\DBMSConnection;

/**
 * “Show example2” action.
 */
class ShowExample2 extends Example2Action
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample2 = new SelectExample2(dbmsConnection: $this->dbmsConnection);

        $example2 = $selectExample2->selectById(id: (int) $this->httpRequest->getGetVariableByName(name: 'id'));

        echo '<p>field1 : ' . $example2->getField1() . ', example field1 : ' . $example2->getExample()->getField1() .
            ', example field2 : ' . $example2->getExample()->getField2() . '.';
    }
}
