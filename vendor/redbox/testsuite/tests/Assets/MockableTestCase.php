<?php

/**
 * MockableTest.php
 *
 * This file creates a fake mocked test instance that i can use for testing.
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
use Redbox\Testsuite\TestCase;

/**
 * Class MockableTestCase
 *
 * @package Redbox\Testsuite\Tests\Assets
 */
class MockableTestCase extends TestCase
{
    /**
     * Minimal score.
     *
     * @var int
     */
    public int $minscore = 0;
    
    /**
     * Maximal score.
     *
     * @var int
     */
    public int $maxscore = 0;
    
    /**
     * Create an instance with a score min value and max value.
     *
     * @param int $score The score to initialize the mock with.
     * @param int $min   The minimal score to initialize the mock with (optional)
     * @param int $max   The maximal score to initialize the mock with (optional)
     *
     * @return MockableTestCase
     */
    public static function createWith($score = 0, $min = 0, $max = 0): MockableTestCase
    {
        $instance = self::create();
        $instance->score->setScore($score);
        
        $instance->minscore = $min;
        $instance->maxscore = $max;
        
        return $instance;
    }
    
    /**
     * Create an instance of the MockableTest.
     *
     * @return MockableTestCase
     */
    public static function create(): MockableTestCase
    {
        return new static();
    }

    /**
     * Run the test.
     *
     * @param ContainerInterface $container The storage container for the TestSuite.
     *                                        
     * @return bool
     */
    public function run(ContainerInterface $container)
    {
        return true;
    }
}
