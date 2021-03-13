<?php

/**
 * MockableContainer.php
 *
 * An empty version of a container.
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

namespace Redbox\Testsuite\Tests\Assets;

use Redbox\Testsuite\Interfaces\ContainerInterface;

/**
 * Class MockableContainer
 *
 * @package Redbox\Testsuite\Tests\Assets
 */
class MockableContainer implements ContainerInterface
{
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
        // TODO: Implement has() method.
    }
    
    /**
     * Return a value from the container with the provided key.
     *
     * @param string $key The identification key.
     *
     * @return mixed|bool
     */
    public function get(string $key)
    {
        // TODO: Implement get() method.
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
        // TODO: Implement set() method.
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
        // TODO: Implement forget() method.
    }
}
