<?php

/**
 * TestSuite.php
 *
 * This Testsuite allows you to run tests.
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
use SplObjectStorage;

class TestSuite
{
    /**
     * Storage to contain the
     * tests.
     *
     * @var SplObjectStorage|null
     */
    protected ?SplObjectStorage $tests = null;

    /**
     * Storage container to contain information
     * for the tests.
     *
     * @var ContainerInterface|null
     */
    protected ?ContainerInterface $container = null;

    /**
     * Test Score counter.
     *
     * @var int|double
     */
    protected $score = 0;

    /**
     * TestSuite constructor.
     */
    public function __construct()
    {
        $this->tests = new SplObjectStorage;

        $this->setContainer(new Container());
    }

    /**
     * This function will be called before every
     * test.
     *
     * @return void
     */
    public function beforeTest()
    {
        // Overwrite at will
    }

    /**
     * This function will be called after every
     * test.
     *
     * @return void
     */
    public function afterTest()
    {
        // Overwrite at will
    }

    /**
     * Set he storage container for the test suite.
     *
     * @param ContainerInterface $container The storage container for the test suite.
     *
     * @return $this
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Return the storage container.
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Reset the score and rewind
     * the tests storage.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->score = 0;

        if ($this->tests->count() > 0) {
            foreach ($this->tests as $test) {
                $test->score->reset();
            }
        }
    }

    /**
     * Attach a Test or an array of
     * Tests to the TestSuite.
     *
     * @param $info The Test to attach.
     *
     * @return $this
     */
    public function attach($info): self
    {
        if (is_array($info) === true) {
            foreach ($info as $test) {
                $this->attach($test);
            }
        } else {
            $test = $info;

            if (is_string($info) === true && class_exists($info) === true) {
                $test = new $info();
            }

            if (is_subclass_of($test, TestCase::class) === false) {
                throw new \InvalidArgumentException('This Test does not extend the TestCase abstract class.');
            }

            $test->setName(get_class($test) . '_' . $this->tests->count());

            $this->tests->attach($test);
        }

        return $this;
    }

    /**
     * Detach a given test from the
     * TestSuite.
     *
     * @param TestCase $test The test to detach.
     *
     * @return $this
     */
    public function detach(TestCase $test): self
    {
        $this->tests->detach($test);
        return $this;
    }

    /**
     * Check to see if the TestSuite has a given
     * test inside.
     *
     * @param TestCase $test The Test to check for.
     *
     * @return bool
     */
    public function has(TestCase $test): bool
    {
        return $this->tests->contains($test);
    }

    /**
     * Run the tests
     *
     * @param bool $reset Will the tests reset before running.
     *
     * @return int
     */
    public function run($reset = true): int
    {
        $tests_run = 0;

        /**
         * Reset the test results
         */
        if ($reset === true) {
            $this->reset();
        }

        $container = $this->getContainer();

        foreach ($this->tests as $test) {
            $this->beforeTest();

            $test->run($container);

            $this->afterTest();

            $this->score += $test->score->getScore();
            $tests_run++;
        }

        return $tests_run;
    }

    /**
     * Return the answers/motivations from all tests.
     *
     * @return array
     */
    public function getAnswers(): array
    {
        $info = [];
        if ($this->tests->count() > 0) {
            foreach ($this->tests as $test) {
                $info[$test->getName()] = $test->score->getScoreInfo();
            }
        }

        return $info;
    }

    /**
     * Return the test suite score.
     *
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Return all tests.
     *
     * @return SplObjectStorage
     */
    public function getTests(): SplObjectStorage
    {
        return $this->tests;
    }

    /**
     * Return the score average for
     * this TestSuite.
     *
     * @return false|float|int
     */
    public function average()
    {
        return ($this->tests->count() > 0) ? ($this->getScore() / $this->tests->count()) : false;
    }
}
