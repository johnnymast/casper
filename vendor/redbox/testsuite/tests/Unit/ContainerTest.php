<?php

/**
 * ContainerTest.php
 *
 * This test Suite tests all Container (class) functions.
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

namespace Redbox\Testsuite\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUNIT_TestCase;
use Redbox\Testsuite\Container;

/**
 * Class ContainerTest
 *
 * @package Redbox\Testsuite\Tests\Unit
 */
class ContainerTest extends PHPUNIT_TestCase
{
    /**
     * Container instance to run tests on.
     *
     * @var Container
     */
    protected Container $container;
    
    /**
     * This function will be executed before all test functions.
     * This means a fresh container instance for every test in this suite.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->container = new Container();
    }
    
    /**
     * Test getting and setting should work correctly.
     *
     * @return void
     */
    public function test_get_and_set_should_work_correctly(): void
    {
        $this->container->set('__FIRST__', 'second');
        
        $actual = $this->container->get('__FIRST__');
        $expected = 'second';
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test that get should return false if a key does not exist.
     *
     * @return void
     */
    public function test_get_should_return_false_for_nonexistent_key(): void
    {
        $this->assertFalse($this->container->get('__NON_EXISTING_KEY'));
    }
    
    /**
     * Test that the has function returns true if the key is present.
     *
     * @return void
     */
    public function test_has_returns_true_if_key_is_present(): void
    {
        $this->container->set('__SECOND__', 'some value');
        $this->assertTrue($this->container->has('__SECOND__'));
    }

    /**
     * Test that the has function returns false if the key is not present.
     *
     * @return void
     */
    public function test_has_returns_false_if_key_is_not_present(): void
    {
        $this->assertFalse($this->container->has('__SECOND__'));
    }

    /**
     * Test the forget function works correctly.
     *
     * @return void
     */
    function test_forget_works_correctly(): void
    {
        $this->container->set('__VAL__', 'some other value');
        
        $this->assertTrue($this->container->has('__VAL__'));
        
        $this->container->forget('__VAL__');
        
        $this->assertFalse($this->container->has('__VAL__'));
    }
}
