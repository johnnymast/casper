<?php

/**
 * TestCase.php
 *
 * The abstract class for Tests inside the TestSuite.
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
 * Class Test
 *
 * @package Redbox\Testsuite
 */
abstract class TestCase
{
    /**
     * Instance that keeps track of the score
     * for this test.
     *
     * @var Score|null
     */
    public ?Score $score = null;

    /**
     * The name of this TestCase.
     *
     * @var string
     */
    private string $name = '';

    /**
     * Test constructor.
     *
     * Note: Tests cant overwrite the function.
     */
    final function __construct()
    {
        if (!isset($this->minscore))
            throw new \LogicException(
                get_class($this) . ' must have property $minscore to indicate the lowest reachable score.'
            );

        if (!isset($this->maxscore))
            throw new \LogicException(
                get_class($this) . ' must have property $maxscore to indicate the highestreachable score.'
            );


        $this->score = new Score($this);
        $this->afterCreation();
    }

    /**
     * This function will be called from within the constructor.
     * This allows you to setup some data from within your test.
     *
     * @return void
     */
    protected function afterCreation()
    {
        // Overwrite at will
    }

    /**
     * Return the name of the test.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the test name.
     *
     * @param string $name The name of the test.
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Tests must implement this method to indicate
     * the maximum score this test can reach.
     *
     * @return int
     */
    public function minScore(): int
    {
        return $this->minscore;
    }

    /**
     * Tests must implement this method to indicate
     * the maximum score this test can reach.
     *
     * @return int
     */
    public function maxScore(): int
    {
        return $this->maxscore;
    }

    /**
     * Tests must implement this method to start
     * running their tests.
     *
     * @param ContainerInterface $container The storage container for the TestSuite.
     *
     * @return void
     */
    abstract public function run(ContainerInterface $container);
}
