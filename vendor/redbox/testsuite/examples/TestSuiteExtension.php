<?php

/**
 * TestSuiteExtension.php
 *
 * This file demonstrate how you can extend the TestSuite
 * class to add your own functionality to it.
 *
 * PHP version 7.4
 *
 * @category Examples
 * @package  RedboxTestSuite
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/johnnymast/redbox-testsuite
 * @since    1.0
 */

require __DIR__ . '/../vendor/autoload.php';

use Redbox\Testsuite\Interfaces\ContainerInterface;
use Redbox\Testsuite\TestCase;
use Redbox\Testsuite\TestSuite;

class TestSuiteExtension extends TestSuite
{

    /**
     * This function will be called before every
     * test.
     *
     * @return void
     */
    public function beforeTest()
    {
        echo "beforeTest called\n";
    }

    /**
     * This function will be called after every
     * test.
     *
     * @return void
     */
    public function afterTest()
    {
        echo "afterTest called\n";
    }
}

class FirstTest extends TestCase
{
    /**
     * Tell the TestCase what the
     * min reachable score is.
     *
     * @var int
     */
    protected int $minscore = 0;

    /**
     * Tell the TestCase what the
     * max reachable score is.
     *
     * @var int
     */
    protected int $maxscore = 3;

    /**
     * Run the test.
     *
     * @param ContainerInterface $container The storage container for the TestSuite.
     *
     * @return void
     */
    public function run(ContainerInterface $container)
    {
        // Nothing here
    }
}

class SecondTest extends FirstTest
{

}

$suite = new TestSuiteExtention();
$suite->attach([FirstTest::class, SecondTest::class])
    ->run();
