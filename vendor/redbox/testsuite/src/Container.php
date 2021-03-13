<?php

/**
 * Container.php
 *
 * This is the internal storage container for test suites.
 *
 * PHP version 7.4
 *
 * @category Core
 * @package  RedboxTestSuite
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-testsuite
 * @since    1.0
 */

namespace Redbox\Testsuite;

use Redbox\Testsuite\Interfaces\ContainerInterface;

/**
 * Class Container
 *
 * @package Redbox\Testsuite
 */
class Container implements ContainerInterface
{
    /**
     * Internal storage for the container.
     *
     * @var array
     */
    protected array $storage = [];
    
    /**
     * Check to see if any information has been stored in the
     * container using the provided key.
     *
     * @param string $key The identification key.
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->storage[$key]);
    }
    
    /**
     * Return a value from the container with a key.
     *
     * @param string $key The identification key.
     *
     * @return mixed|bool
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $this->storage[$key];
        }
        
        return false;
    }
    
    /**
     * Store a value in the container indicated by this key.
     *
     * @param string $key   The identification key.
     * @param mixed  $value The value for the $key.
     *
     * @return void
     */
    public function set(string $key, $value): void
    {
        if (!is_null($key)) {
            $this->storage[$key] = $value;
        }
    }
    
    /**
     * Forget a value in the container by this key.
     *
     * @param string $key The key to forget.
     *
     * @return void
     */
    public function forget(string $key): void
    {
        if ($this->has($key)) {
            unset($this->storage[$key]);
        }
    }
}
