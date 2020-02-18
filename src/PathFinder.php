<?php

namespace PathFinder;

class PathFinder 
{
    protected $path;

    /**
     * @var $path The working directory. If it's not given the current working directory will be used
     */
    public function __construct(string $path = null) 
    {
        $this->path = $this->here($path);
    }

    /**
     * Synonym for constructor
     * 
     * @see self::__construct
     */
    public function here(string $path = null)
    {
        $this->path = $this->currentWorkindDir($path);
        return $this;
    }

    public function goto(string $dir)
    {
        $this->path = $this->path . DIRECTORY_SEPARATOR . $dir;
        return $this;
    }

    /**
     * Goes up one level
     * @return PathFinder
     */
    public function up()
    {
        $parts = explode(DIRECTORY_SEPARATOR, $this->path);
        $parentParts = array_slice($parts, 0, count($parts) - 1);
        
        $this->path = join(DIRECTORY_SEPARATOR, $parentParts);
        return $this;
    }

    public function addRoot(string $rootDir)
    {
        $this->path = strpos($this->path, DIRECTORY_SEPARATOR) === 0
            ? $this->path 
            : (DIRECTORY_SEPARATOR . $this->path);

        $this->path = $rootDir . $this->path;
        return $this;
    }

    /**
     * Synonym for up()
     * 
     * @return PathFinder
     * @see self::up()
     */
    public function back()
    {
        return $this->up();   
    }

    public function getFirst()
    {
        $parts = $this->getParts();
        return $parts[0];
    }

    public function getLast()
    {
        $parts = $this->getParts();
        return $parts[count($parts) - 1];
    }

    /**
     * $this->path = /Users/user/code/src/MyProject/Namespace/MyClass.php
     * 
     * $dirname = 'MyProject'
     * $destination = /Users/user/outout/MyProject
     * 
     * Result = /Users/user/output/MyProject/Namespace/MyClass.php
     */
    public function mix(string $dirname, string $destination)
    {
        $pathParts = $this->getParts();
        $dirIndex = array_search($dirname, $pathParts);

        $this->path = $destination . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array_slice($pathParts, $dirIndex + 1));
        return $this;
    }

    public function createRecursive()
    {
        $parts = $this->getParts();
        $prefix = '';
        
        foreach ($parts as $part) {
            if (empty($part)) continue;

            $fullPath = $prefix . $part;
            if (!is_dir($fullPath))
                mkdir($fullPath);

            $prefix = $fullPath . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * Returns the parts of path
     * @return array
     */
    protected function getParts(): array
    {
        // @TODO /Users ... esetén az első elem egy null lesz 
        return explode(DIRECTORY_SEPARATOR, $this->path);
    }

    protected function currentWorkindDir(string $path = null) 
    {
        return $path ? $path : getcwd();
    }

    public function __toString()
    {
        return $this->path;
    }
}