<?php
namespace PHPeacock\Framework\Routing;

/**
 * Abstract controller which executes an action.
 */
abstract class Controller
{
    /**
     * Action to execute.
     * @var Action $action
     */
    protected Action $action;

    /**
     * Executes an action.
     * 
     * @return void
     */
    public function render(): void
    {
        $this->action->execute();
    }

    /**
     * Returns the action property.
     * 
     * @return Action
     */
    public function getAction(): Action
    {
        return $this->action;
    }

    /**
     * Sets the action property.
     * 
     * @param Action $action Action to execute.
     * 
     * @return void
     */
    public function setAction(Action $action): void
    {
        $this->action = $action;
    }
}
