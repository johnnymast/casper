<?php

/**
 * Anonclass.php
 *
 * This file demonstrate how you could use Anonymous classes to
 * attach to the the test suite.
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

require __DIR__.'/../vendor/autoload.php';

use Redbox\Testsuite\Interfaces\ContainerInterface;
use Redbox\Testsuite\TestCase;
use Redbox\Testsuite\TestSuite;

$suite = new TestSuite();
$suite->attach(
    /**
     * Anonymous class
     */
    new class extends TestCase {

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
        protected int $maxscore = 10;
    
        /**
         * Run the test.
         *
         * @param ContainerInterface $container The storage container for the TestSuite.
         *
         * @return bool
         */
        public function run(ContainerInterface $container)
        {
            echo "Test case has run.\n";
        }
    }
)->run();

/**
 * Output:
 *
 * Test case has run.
 */
