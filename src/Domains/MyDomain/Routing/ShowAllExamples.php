<?php
namespace MyApp\Domains\MyDomain\Routing;

use MyApp\Domains\MyDomain\SelectExample;
use PHPeacock\Framework\Exceptions\Persistence\Entities\SelectEntityException;
use PHPeacock\Framework\Exceptions\Routing\ExecuteActionException;

/**
 * “Show all examples” action.
 */
class ShowAllExamples extends ExampleAction
{
    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $selectExample = new SelectExample(dbmsConnection: $this->dbmsConnection);

        try
        {
            $allExamples = $selectExample->selectAll();
        }
        catch (SelectEntityException $exception)
        {
            throw new ExecuteActionException(
                message: 'An error occurs when executing an “Show all examples” action.',
                previous: $exception
            );
        }

        //foreach ($allExamples as $example)
        //{
        //    echo
        //        '<p>field1 : ' . $example->getField1() . ', field2 : ' . $example->getField2() .
        //        '. <a href="example/' . $example->getId() . '">Détail</a> ' .
        //        '<a href="remove-example/' . $example->getId() . '">Supprimer</a></p>';
        //}

        require 'test.php';
    }
}
