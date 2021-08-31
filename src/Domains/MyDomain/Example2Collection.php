<?php
namespace MyApp\Domains\MyDomain;

use PHPeacock\Framework\Persistence\Entities\EntityCollection;

/**
 * Collection of example2s.
 */
class Example2Collection extends EntityCollection
{
    /**
     * @param Example2 $example2s,... Example2s to add.
     */
    public function __construct(Example2 ...$example2s)
    {
        parent::__construct(...$example2s);
    }

    /**
     * Adds the example2 to the collection.
     * 
     * @param Example2 $example2 Example2 to add.
     * 
     * @return self
     */
    public function attach(Example2 $example2): self
    {
        $this->elements->attach(object: $example2);
        return $this;
    }

    /**
     * Removes the example2 from the collection.
     * 
     * @param Example2 $example2 Example2 to remove.
     * 
     * @return self
     */
    public function detach(Example2 $example2): self
    {
        $this->elements->detach(object: $example2);
        return $this;
    }
}
