<?php
namespace PHPeacock;

use PHPeacock\Framework\Exceptions\FileNotFoundException;

/**
 * Application autoloader.
 * 
 * This autoloader deals with classes in `src` folder.
 * Their namespace must follow their path into `src`, and begin with the application name.
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
     * @throws FileNotFoundException if the loaded file does not exist.
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
            if ($i === $nameFragmentsLength - 1)
            {
                $path[] = $nameFragments[$i];
            }
            else
            {
                $path[] = strtolower(string: $nameFragments[$i]);
            }
        }

        $file = implode(separator: DIRECTORY_SEPARATOR, array: $path) . '.php';
        if (file_exists(stream_resolve_include_path($file)))
        {
            require_once $file;
        }
        else
        {
            throw new FileNotFoundException(message: $file);
        }
    }
}
