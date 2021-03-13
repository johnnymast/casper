<?php

/**
 * Container.php
 *
 * This file demonstrate how to add values to the suite storage container
 * and use it inside the tests.
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

/**
 * Class MyFirstTest
 */
class MyFirstTestCase extends TestCase
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
    protected int $maxscore = 10;
    
    /**
     * Demo function show how values are passed.
     *
     * @param string $word Word to echo.
     *
     * @return void
     */
    protected function say(string $word): void
    {
        echo $word."\n";
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
        if ($container->has('words')) {
            $words = $container->get('words');
            
            foreach ($words as $word) {
                $this->say($word);
            }
        }
        
        return true;
    }
}

/**
 * Instantiate the test.
 */
$testInstance = new MyFirstTestCase();

/**
 * Create a test suite and attach the test.
 */
$suite = new TestSuite();
$suite->attach($testInstance);

$suite->getContainer()->set('words', ["Hello", "2021", "How", "Are", "You?"]);

$suite->run();
