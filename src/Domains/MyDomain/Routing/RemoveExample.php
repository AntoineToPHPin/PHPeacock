<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample;
use PHPeacock\Framework\Exceptions\Persistence\PersistenceException;
use PHPeacock\Framework\Exceptions\Routing\ExecuteActionException;

/**
 * “Remove example” action.
 */
class RemoveExample extends ExampleAction
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        try
        {
            $selectExample = new SelectExample(dbmsConnection: $this->dbmsConnection);

            $example = $selectExample->selectById(id: (int) $this->httpRequest->getGetVariableByName(name: 'id'));

            $example->delete();

            header('Location: http://www.antoine-tophin.fr/examples');
        }
        catch (PersistenceException $exception)
        {
            throw new ExecuteActionException(
                message: 'The “remove example” action failed.',
                previous: $exception
            );
        }
    }
}
