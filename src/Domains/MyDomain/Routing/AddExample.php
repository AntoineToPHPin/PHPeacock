<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\Example;

/**
 * “Add example” action.
 */
class AddExample extends ExampleAction
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $example = new Example(
            dbmsConnection: $this->dbmsConnection,
            field1: $this->httpRequest->getPostVariableByName(name: 'field1'),
            field2: $this->httpRequest->getPostVariableByName(name: 'field2'),
        );

        $example->insert();

        header('Location: http://www.antoine-tophin.fr/examples');
    }
}
