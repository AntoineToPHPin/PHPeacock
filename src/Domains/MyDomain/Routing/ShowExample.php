<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample;
use PHPeacock\Framework\Exceptions\Persistence\Entities\SelectEntityException;
use PHPeacock\Framework\Exceptions\Routing\ExecuteActionException;

/**
 * “Show example” action.
 */
class ShowExample extends ExampleAction
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample = new SelectExample(dbmsConnection: $this->dbmsConnection);

        try
        {
            $example = $selectExample->selectById(id: (int) $this->httpRequest->getGetVariableByName(name: 'id'));
        }
        catch (SelectEntityException $exception)
        {
            throw new ExecuteActionException(
                message: 'An error occurs when executing an “Show example” action.',
                previous: $exception
            );
        }

        echo
            '<p>field1 : ' . $example->getField1() . ', field2 : ' . $example->getField2() . '.</p>' .
            '<p><form method="post" action="/change-example"><input type="hidden" name="ch-id" value="' . $example->getId() . '">' .
            'Field1 : <input type="text" name="ch-field1" value="' . $example->getField1() . '">'.
            'Field2 : <input type="text" name="ch-field2" value="' . $example->getField2() . '"><form>' .
            '<input type="submit" value="modifier"></p>';
    }
}
