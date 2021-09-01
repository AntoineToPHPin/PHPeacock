<?php
namespace PHPeacock;

use PHPeacock\Framework\Exceptions\Autoloader\ClassNotFoundException;

/**
 * Application autoloader.
 * 
 * This autoloader deals with classes in `src` folder.
 * Their namespace must follow their path into `src`, and begin with the application name.
 * It is case-sensitive.
 */
class Autoloader
{
    /**
     * Registers the `load` method to the autoload queue.
     * 
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register(callback: [$this, 'load']);
    }

    /**
     * Loads a class.
     * 
     * @param string $className Name of the class, with namespace.
     * 
     * @throws ClassNotFoundException if the loaded class is not found.
     * 
     * @return void
     */
    protected function load(string $className): void
    {
        $nameFragments = explode(separator: '\\', string: $className);
        $nameFragmentsLength = count(value: $nameFragments);

        $path = [];
        for ($i = 1; $i < $nameFragmentsLength; $i++)
        {
            $path[] = $nameFragments[$i];
        }

        $file = implode(separator: DIRECTORY_SEPARATOR, array: $path) . '.php';
        if (file_exists(filename: stream_resolve_include_path(filename: $file)))
        {
            require_once $file;
        }
        else
        {
            throw new ClassNotFoundException(message: $className . ' is not found.');
        }
    }
}
