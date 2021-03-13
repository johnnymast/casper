<?php

/**
 * TestCaseTest.php
 *
 * This test suite will test all Test Abstract related functions.
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
use Redbox\Testsuite\Interfaces\ContainerInterface;
use Redbox\Testsuite\Tests\Assets\MockableTestCase;

/**
 * Class TestTest
 *
 * @package Redbox\Testsuite\Tests\Unit
 */
class TestCaseTest extends PHPUNIT_TestCase
{
    /**
     * The test instance used for all the tests.
     *
     * @var TestCase
     */
    protected $testInstance;
    
    /**
     * A test container.
     *
     * @var Container
     */
    protected Container $testContainer;
    
    /**
     * This function will be executed before all test functions.
     * This means a fresh test instance for every test in this suite.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->testInstance = new class extends \Redbox\Testsuite\TestCase {

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
             * Fake method for testing.
             *
             * @return void
             */
            private function executeTest1(): void
            {
                $this->score->increment(2);
            }
            
            /**
             * Run the test.
             *
             * @param ContainerInterface $container The storage container for the TestSuite.
             *
             * @return bool
             */
            public function run(ContainerInterface $container): bool
            {
                $this->executeTest1();
                return true;
            }
        };
        
        $this->testContainer = new Container();
    }
    
    /**
     * Test that the default score is set to the min score.
     *
     * @return void
     */
    public function test_score_is_0_by_default(): void
    {
        $this->assertEquals(0, $this->testInstance->score->getScore());
    }
    
    /**
     * Test that set and get score are working correctly.
     *
     * @return void
     */
    public function test_set_and_get_score_work_correct(): void
    {
        $this->testInstance->score->setScore(5);
        
        $this->assertEquals(5, $this->testInstance->score->getScore());
    }
    
    /**
     * Test that the score on a test can be incremented.
     *
     * @return void
     */
    public function test_core_can_be_incremented(): void
    {
        $this->testInstance->score->setScore(5);
        $this->testInstance->score->increment(5);
        $this->assertEquals(10, $this->testInstance->score->getScore());
    }
    
    /**
     * Test that, after a test run the score is stored correctly.
     *
     * @return void
     */
    public function test_run_could_increment_score(): void
    {
        $this->testInstance->run($this->testContainer);
        $this->assertEquals(2, $this->testInstance->score->getScore());
    }
    
    /**
     * Test that the score instance gets the min score from a test instance.
     *
     * @return void
     */
    public function test_score_knows_the_min_score(): void
    {
        $this->assertEquals(0, $this->testInstance->score->minScore());
    }
    
    /**
     * Test that the score instance gets the max score from a test instance.
     *
     * @return void
     */
    public function test_score_knows_the_max_score(): void
    {
        $this->assertEquals(4, $this->testInstance->score->maxScore());
    }
    
    /**
     * Test that the average score is communicated correctly.
     *
     * @return void
     */
    public function test_average_can_be_correctly_calculated(): void
    {
        $this->testInstance->score->increment(5);
        $this->testInstance->score->increment(5);
        $this->testInstance->score->increment(5);
        $this->assertEquals(5, $this->testInstance->score->average());
    }
    
    /**
     * Test that the average does not divide by zero if there is no score.
     *
     * @return void
     */
    public function test_average_does_not_divide_by_zero_increments_but_returns_false(): void
    {
        $this->assertEquals(0, $this->testInstance->score->average());
        $this->assertFalse($this->testInstance->score->average());
    }
    
    /**
     * Test percentage on score is calculated correctly.
     *
     * @return void
     */
    public function test_percentage_is_calculated_correctly(): void
    {
        /**
         * After running the score will be 2 + 1 = 4.
         * This will calculate percentage of 3 out of 4 (max score).
         */
        $this->testInstance->run($this->testContainer);
        $this->testInstance->score->increment(1);
        $this->assertEquals(75, $this->testInstance->score->percentage());
    }
    
    /**
     * Test that score increments are calculated the rights way.
     *
     * @return void
     */
    public function test_increments_is_calculated_correctly(): void
    {
        $this->testInstance->score->increment(2);
        $this->testInstance->score->increment(2);
        $this->assertEquals(2, $this->testInstance->score->getIncrements());
    }
    
    /**
     * Test that empty tests have a 0% percentage score.
     *
     * @return void
     */
    public function test_percentage_should_be_0_without_increments(): void
    {
        $this->assertEquals(0, $this->testInstance->score->percentage());
    }
    
    /**
     * Test the reset function.
     *
     * @return void
     */
    public function test_the_reset_function_resets_to_default(): void
    {
        $this->testInstance->score->increment(11);
        $this->testInstance->score->increment(11);
        $this->testInstance->score->reset();
        
        $this->assertEquals(0, $this->testInstance->score->getScore());
        $this->assertEquals(0, $this->testInstance->score->getIncrements());
        $this->assertCount(0, $this->testInstance->score->getScoreInfo());
    }
    
    /**
     * Return that the score returns the test correctly.
     *
     * @return void
     */
    public function test_score_gettest_returns_the_test(): void
    {
        $this->assertEquals($this->testInstance, $this->testInstance->score->getTest());
    }

    /**
     * Test that afterCreation() is being called.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_if_min_or_maxscore_are_not_defined_we_get_a_exception(): void
    {
        $this->expectException(\LogicException::class);
        $this->getMockBuilder(\Redbox\Testsuite\TestCase::class)->getMock();
    }
    
    /**
     * Test that afterCreation() is being called.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_aftercreation_is_being_called(): void
    {
        $mock = $this->getMockBuilder(MockableTestCase::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['afterCreation', 'run'])
            ->getMock();
        
        $mock->expects($this->once())
            ->method('afterCreation');
        
        $reflectedClass = new \ReflectionClass(\Redbox\Testsuite\TestCase::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock);
    }
}
