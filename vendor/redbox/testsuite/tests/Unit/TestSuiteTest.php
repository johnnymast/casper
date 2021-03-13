<?php

/**
 * TestSuiteTest.php
 *
 * This test Suite tests all TestSuite (class) functions.
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
use Redbox\Testsuite\Interfaces\ContainerInterface;
use Redbox\Testsuite\Tests\Assets\MockableContainer;
use Redbox\Testsuite\Tests\Assets\MockableTestCase;
use Redbox\Testsuite\TestSuite;
use Redbox\Testsuite\TestCase;

/**
 * Class TestSuiteTest
 *
 * @package Redbox\Testsuite\Tests\Unit
 */
class TestSuiteTest extends PHPUNIT_TestCase
{
    
    /**
     * Check if there is a default container present upon initialization.
     *
     * @return void
     */
    function test_it_should_have_a_default_container(): void
    {
        $suite = new TestSuite();
        $this->assertInstanceOf(ContainerInterface::class, $suite->getContainer());
    }
    
    /**
     * Test if setting and then retrieving a container via getContainer
     * returns the same object.
     *
     * @return void
     */
    function test_it_should_be_able_of_setting_custom_container(): void
    {
        $container = new MockableContainer();
        $suite = new TestSuite();
        
        $suite->setContainer($container);

        $this->assertInstanceOf(MockableContainer::class, $suite->getContainer());
    }

    /**
     * Test setContainer() returns $this.
     *
     * @return void
     */
    public function test_setcontainer_returns_self(): void
    {
        $suite = new TestSuite();
        $container = new MockableContainer();

        $this->assertInstanceOf(TestSuite::class, $suite->setContainer($container));
    }
    
    /**
     * Test that an \InvalidArgumentException will be
     * thrown if the test not has type Test.
     *
     * @return void
     */
    public function test_attach_only_takes_tests(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $suite = new TestSuite();
        $suite->attach('invalid_type');
    }

    /**
     * Test attach() returns $this.
     *
     * @return void
     */
    public function test_attach_returns_self(): void
    {
        $suite = new TestSuite();
        $this->assertInstanceOf(TestSuite::class, $suite->attach(MockableTestCase::class));
    }
    
    /**
     * Test it can attach a single test.
     *
     * @return void
     */
    public function test_it_can_attach_a_single_test(): void
    {
        $test = $this->createMock(TestCase::class);
        $suite = new TestSuite();
        $suite->attach($test);
        
        $this->assertTrue($suite->has($test));
    }
    
    /**
     * Test it can attach multiple tests.
     *
     * @return void
     */
    public function test_it_can_attach_multiple_tests(): void
    {
        $test1 = $this->createMock(TestCase::class);
        $test2 = $this->createMock(TestCase::class);
        $suite = new TestSuite();
        $suite->attach([$test1, $test2]);
        
        $this->assertTrue($suite->has($test1));
        $this->assertTrue($suite->has($test2));
    }
    
    /**
     * Test it can detach a test.
     *
     * @return void
     */
    public function test_it_can_detach_a_test(): void
    {
        $test = $this->createMock(TestCase::class);
        $suite = new TestSuite();
        $suite->attach($test);
        
        $this->assertTrue($suite->has($test));
        
        $suite->detach($test);
        $this->assertFalse($suite->has($test));
    }
    
    /**
     * Test detach() returns $this.
     *
     * @return void
     */
    public function test_detach_returns_self(): void
    {
        $suite = new TestSuite();
        $test = MockableTestCase::create();
        
        $suite->attach($test);
        $this->assertInstanceOf(TestSuite::class, $suite->detach($test));
    }
    
    /**
     * Test getTests returns all tests.
     *
     * @return void
     */
    function test_gettests_should_return_all_tests(): void
    {
        $test = $this->createMock(TestCase::class);
        
        $suite = new TestSuite();
        $suite->attach($test);
        
        $this->assertContains($test, $suite->getTests());
    }
    
    /**
     * Test that the run function will return 1 test.
     * for being run.
     *
     * @return void
     */
    public function test_it_can_run_once(): void
    {
        $test = MockableTestCase::createWith(1);
        
        $suite = new TestSuite();
        $actual = $suite->attach($test)
            ->run();

        $expected = 1;
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test that the run function will return 2 tests.
     * for being having 2 tests ran.
     *
     * @return void
     */
    public function test_it_can_multiple_tests(): void
    {
        $test1 = MockableTestCase::createWith(1);
        $test2 = MockableTestCase::createWith(2);
        
        $suite = new TestSuite();
        $suite->attach([$test1, $test2]);
        
        $actual = $suite->run();
        $expected = 2;
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test one test can be attached by just using a classname. This
     * test will automatically be loaded by the test suite.
     *
     * @return void
     */
    function test_attach_one_test_by_class_name(): void
    {
        $suite = new TestSuite();
        
        $this->assertCount(0, $suite->getTests());
        $suite->attach(MockableTestCase::class);
        
        $this->assertCount(1, $suite->getTests());
        
        $expected = 1;
        $counter = 0;
        $ofType = MockableTestCase::class;
        
        foreach ($suite->getTests() as $test) {
            if ($test instanceof $ofType) {
                $counter++;
            }
        }
        
        $this->assertEquals($expected, $counter);
    }
    
    /**
     * Test multiple tests can be attached by just using a classname. These
     * tests will automatically be loaded by the test suite.
     *
     * @return void
     */
    function test_attach_multiple_tests_by_class_name(): void
    {
        $suite = new TestSuite();
        
        $this->assertCount(0, $suite->getTests());
        $suite->attach([MockableTestCase::class, MockableTestCase::class]);
        
        $this->assertCount(2, $suite->getTests());
        
        $expected = 2;
        $counter = 0;
        $ofType = MockableTestCase::class;
        
        foreach ($suite->getTests() as $test) {
            if ($test instanceof $ofType) {
                $counter++;
            }
        }
        
        $this->assertEquals($expected, $counter);
    }
    
    /**
     * Test it can get the score of one test.
     *
     * @return void
     */
    public function test_it_can_calculate_score_of_one_test(): void
    {
        $test = MockableTestCase::createWith(4);
        
        $suite = new TestSuite();
        $suite->attach($test);
        $suite->run(false);
        
        $actual = $suite->getScore();
        $expected = 4;
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test it can calculate score of multiple running tests.
     *
     * @return void
     */
    public function test_it_can_calculate_score_of_multiple_tests(): void
    {
        $test1 = MockableTestCase::createWith(4);
        $test2 = MockableTestCase::createWith(5);
        
        $suite = new TestSuite();
        $suite->attach([$test1, $test2]);
        $suite->run(false);
        
        $actual = $suite->getScore();
        $expected = 9;
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test getScore returns the correct value.
     *
     * @return void
     */
    public function test_getscore_returns_the_correct_value(): void
    {
        $test1 = MockableTestCase::createWith();
        $test1->score->increment(4);
        
        $suite = new TestSuite();
        $suite->attach([$test1]);
        $suite->run(false);
        
        $actual = $suite->getScore();
        $expected = 4;
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test if the Container passes trough values to the test.
     *
     * @return voic
     */
    public function test_run_should_pass_container_values(): void
    {
        $testClass = new class extends MockableTestCase {
            protected $unitTest = null;
            
            /**
             * Pass the TestSuiteTest to the fake test.
             *
             * @param PHPUNIT_TestCase $unitTest The TestSuiteTest instance.
             *
             * @return void
             */
            public function setUnitTest(PHPUNIT_TestCase $unitTest)
            {
                $this->unitTest = $unitTest;
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
                $expected = 'Hello 2021';
                $this->unitTest->assertEquals($expected, $container->get('__KEY__'));
                return true;
            }
        };
        
        $test = $testClass::create();
        $test->setUnitTest($this);
        
        $suite = new TestSuite();
        $suite->attach($test);
        
        $suite->getContainer()->set('__KEY__', 'Hello 2021');
        $suite->run();
    }
    
    /**
     * Test that names for tests are automatically set within the
     * test suite.
     *
     * @return void
     */
    public function test_all_tests_get_a_unique_name(): void
    {
        $test1 = MockableTestCase::create();
        $test2 = MockableTestCase::create();
        
        $suite = new TestSuite();
        $suite->attach([$test1, $test2]);
        
        $this->assertEquals(get_class($test1).'_0', $test1->getName());
        $this->assertEquals(get_class($test1).'_1', $test2->getName());
    }
    
    /**
     * Test that getAnswers() returns the correct motivations.
     *
     * @return void
     */
    public function test_get_answers_has_the_correct_motivations(): void
    {
        $test1 = MockableTestCase::create();
        $test2 = MockableTestCase::create();
        
        $suite = new TestSuite();
        $suite->attach([$test1, $test2]);
        
        $test1->score->increment(1, '__EEK__');
        $test1->score->increment(2, '__QUAKE__', 'This it answer');
        $test2->score->increment(1, '__DUCK__');
        $test2->score->increment(1, '__SUCK__');
        $test2->score->increment(1, '__MUCK__');
        
        $answers = $suite->getAnswers();
        
        $info = current($answers);
        $this->assertEqualsCanonicalizing(
            $info,
            [
            [
              'score' => 1,
              'increment' => 0,
              'motivation' => '__EEK__',
              'answer' => '',
            ],
            [
              'score' => 2,
              'increment' => 1,
              'motivation' => '__QUAKE__',
              'answer' => 'This it answer'
            ]
            ]
        );
        
        $info = next($answers);
        $this->assertEqualsCanonicalizing(
            $info,
            [
            [
              'score' => 1,
              'increment' => 0,
              'motivation' => '__DUCK__',
              'answer' => '',
            ],
            [
              'score' => 1,
              'increment' => 1,
              'motivation' => '__SUCK__',
              'answer' => '',
            ],
            [
              'score' => 1,
              'increment' => 2,
              'motivation' => '__MUCK__',
              'answer' => '',
            ]
            ]
        );
    }
    
    /**
     * Test that beforeTest() is being called.
     *
     * @return void
     */
    public function test_beforetest_is_being_called(): void
    {
        $test = MockableTestCase::create();
        
        $suite = $this->getMockBuilder(TestSuite::class)
            ->onlyMethods(['beforeTest'])
            ->getMock();
        
        $suite->attach($test);
        
        $suite
            ->expects($this->once())
            ->method('beforeTest');
        
        $suite->run();
    }
    
    /**
     * Test that afterTest() is being called.
     *
     * @return void
     */
    public function test_aftertest_is_being_called(): void
    {
        $test = MockableTestCase::create();

        $suite = $this->getMockBuilder(TestSuite::class)
            ->onlyMethods(['afterTest'])
            ->getMock();
        
        $suite->attach($test);
        
        $suite
            ->expects($this->once())
            ->method('afterTest');
        
        $suite->run();
    }
    
    /**
     * Test that the average of a suite is being returned.
     *
     * @return void
     */
    function test_average_should_return_the_correct_score_average(): void
    {
        $test1 = MockableTestCase::createWith(3);
        $test2 = MockableTestCase::createWith(3);
        $test3 = MockableTestCase::createWith(3);
        
        $suite = new TestSuite();
        $suite->attach([$test1, $test2, $test3])
            ->run(false);
        
        $expected = 3;
        $this->assertEquals($expected, $suite->average());
    }
}
