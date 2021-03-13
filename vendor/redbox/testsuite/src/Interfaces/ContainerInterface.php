<?php

/**
 * ContainerInterface.php
 *
 * Create a interface for containers. This will make sure
 * that Containers are compatible with the core of
 * Redbox TestSuite.
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

namespace Redbox\Testsuite\Interfaces;

/**
 * Interface ContainerInterface
 *
 * @package Redbox\Testsuite\Interfaces
 */
interface ContainerInterface
{
    /**
     * Check to see if any information has been stored in the
     * container using the provided key.
     *
     * @param string $key The identification key.
     *
     * @return bool
     */
    public function has(string $key): bool;
    
    /**
     * Return a value from the container with a key.
     *
     * @param string $key The identification key.
     *
     * @return mixed|bool
     */
    public function get(string $key);
    
    /**
     * Store a value in the container indicated by this key.
     *
     * @param string $key   The identification key.
     * @param mixed  $value The value for the $key.
     *
     * @return void
     */
    public function set(string $key, $value);
    
    /**
     * Forget a value in the container by this key.
     *
     * @param string $key The key to forget.
     *
     * @return void
     */
    public function forget(string $key);
}
