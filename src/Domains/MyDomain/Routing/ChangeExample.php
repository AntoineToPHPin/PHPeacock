<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\Example;

/**
 * “Change example” action.
 */
class ChangeExample extends ExampleAction
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $example = new Example(
            dbmsConnection: $this->dbmsConnection,
            id: (int) $this->httpRequest->getPostVariableByName(name: 'ch-id'),
            field1: $this->httpRequest->getPostVariableByName(name: 'ch-field1'),
            field2: $this->httpRequest->getPostVariableByName(name: 'ch-field2'),
        );

        $example->update();

        header('Location: http://www.antoine-tophin.fr/examples');
    }
}
