<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Persistence\Entities\EntityCollection;

/**
 * Collection of examples.
 */
class ExampleCollection extends EntityCollection
{
    /**
     * @param Example $examples,... Examples to add.
     */
    public function __construct(Example ...$examples)
    {
        parent::__construct(...$examples);
    }

    /**
     * Adds the example to the collection.
     * 
     * @param Example $example Example to add.
     * 
     * @return self
     */
    public function attach(Example $example): self
    {
        $this->elements->attach(object: $example);
        return $this;
    }

    /**
     * Removes the example from the collection.
     * 
     * @param Example $example Example to remove.
     * 
     * @return self
     */
    public function detach(Example $example): self
    {
        $this->elements->detach(object: $example);
        return $this;
    }
}
