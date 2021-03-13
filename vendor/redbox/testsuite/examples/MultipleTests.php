<?php

/**
 * MultipleTests.php
 *
 * This file demonstrate how to add multiple tests to the test suite
 * and run the tests.
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

/**
 * Class TheFirstTestCase
 */
class TheFirstTestCase extends TestCase
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
    protected int $maxscore = 4;

    /**
     * Demo function for answering demo questions.
     *
     * @param bool $correct For demo only if the answer is true mark correct.
     *
     * @return void
     */
    protected function checkAnswer(bool $correct): void
    {
        if ($correct) {
            $this->score->increment(1);
        }
    }

    /**
     * Run the test.
     *
     * @param ContainerInterface $container The storage container for the TestSuite.
     *
     * @return void
     */
    public function run(ContainerInterface $container)
    {
        $this->checkAnswer(true);
        $this->checkAnswer(true);
        $this->checkAnswer(false);
    }
}

class TheSecondTestCase extends TestCase
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
        $this->score->increment(1);
        $this->score->increment(1);
        $this->score->increment(1);
    }
}

/**
 * Instantiate the test.
 */
$test1 = new TheFirstTestCase();
$test2 = new TheSecondTestCase();

/**
 * Create a test suite
 */
$suite = new TestSuite();
$suite->attach([$test1, $test2])
    ->run();

/**
 * Score should be
 *
 * Test score: 2
 *   - Answer 1 correct: true
 *   - Answer 2 correct: true
 *   - Answer 3 correct: false
 * ===================+
 * Total suite score 2
 */

echo "Total suite score: " . $suite->getScore() . "\n";
echo "Percentage complete Test 1: " . $test1->score->percentage() . "\n";
echo "Percentage complete Test 2: " . $test2->score->percentage() . "\n";

/**
 * Output:
 *
 * Total suite score: 5
 * Percentage complete Test 1: 50
 * Percentage complete Test 2: 100
 */
