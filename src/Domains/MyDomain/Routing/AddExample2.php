<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\Example2;
use MyApp\Domains\MyDomain\SelectExample;

/**
 * “Add example2” action.
 */
class AddExample2 extends Example2Action
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample = new SelectExample(dbmsConnection: $this->dbmsConnection);

        $example = $selectExample->selectById(id: (int) $this->httpRequest->getPostVariableByName(name: 'example'));

        $example2 = new Example2(
            dbmsConnection: $this->dbmsConnection,
            field1: $this->httpRequest->getPostVariableByName(name: 'field1'),
            example: $example,
        );

        $this->dbmsConnection->beginTransaction();
        
        $example2->insert();
        
        $this->dbmsConnection->commit();
        die;
        header('Location: http://www.antoine-tophin.fr/example2/' . $example2->getId());
    }
}