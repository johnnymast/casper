<?php

/**
 * TestSuiteSpec.php
 *
 * This file tests the behavior of the TestSuite class.
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

namespace spec\Redbox\Testsuite;

use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Collaborator as CollaboratorAlias;
use Redbox\Testsuite\Interfaces\ContainerInterface;
use Redbox\Testsuite\TestCase;
use Redbox\Testsuite\Tests\Assets\MockableContainer;
use Redbox\Testsuite\Tests\Assets\MockableTestCase;
use Redbox\Testsuite\TestSuite;

/**
 * Class
 * TestSuiteSpec
 *
 * @package spec\Redbox\Testsuite
 */
class TestSuiteSpec extends ObjectBehavior
{
    /**
     * Provides
     *  - shouldBeInstanceOfClassByName()
     *  - shouldNotBeInstanceOfClassByName()
     *  - shouldReturnImplementationOf()
     *  - shouldNotReturnImplementationOf()
     *
     * @return \Closure[]
     */
    public function getMatchers(): array
    {
        return [
          'haveInstancesOfObjectWithType' => function ($subject, $type, $num = 0, $counter = 0) {
            foreach ($subject as $test) {
                if ($test instanceof $type) {
                    $counter++;
                }
            }
              return ($counter == $num);
          },
          'returnImplementationOf' => function ($subject, $interface) {
              return ($subject instanceof $interface);
          }
        ];
    }
    
    /**
     * Test the TestSuite class is initializable.
     *
     * @return void
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(TestSuite::class);
    }
    
    /**
     * Check if there is a default container present upon initialization.
     *
     * @return void
     */
    function it_should_have_a_default_container()
    {
        $this->getContainer()->shouldReturnImplementationOf(ContainerInterface::class);
    }
    
    /**
     * Test if setting and then retrieving a container via getContainer
     * returns the same object.
     *
     * @return void
     */
    function it_should_be_abled_of_setting_custom_container()
    {
        $container = new MockableContainer();
        
        $this->setContainer($container);
        
        $this->getContainer()->shouldBeAnInstanceOf(MockableContainer::class);
    }
    
    /**
     * Test that an invalid argument exception will be thrown if an invalid test is being
     * attached to the testsuite.
     *
     * @return void
     */
    function it_should_not_attach_unknown_tests()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('attach', ['invalid']);
    }
    
    /**
     * Test that attaching a Test works.
     *
     * @param CollaboratorAlias $test This is a fake instance of the Test Abstract.
     *
     * @return void
     */
    function it_should_attach_a_test($test)
    {
        $test->beADoubleOf(TestCase::class);
        
        $this->attach($test);
        $this->has($test)->shouldReturn(true);
    }
    
    /**
     * Test that one Test can be attached to the test suite.
     *
     * @param CollaboratorAlias $test This is a fake instance of the Test Abstract.
     *
     * @return void
     */
    function it_should_detach_a_test(CollaboratorAlias $test)
    {
        $test->beADoubleOf(TestCase::class);
        
        $this->detach($test);
        $this->has($test)->shouldReturn(false);
    }
    
    /**
     * Test getTests returns all tests.
     *
     * @param CollaboratorAlias $test This is a fake instance of the Test Abstract.
     *
     * @return void
     */
    function it_should_return_all_tests_with_gettests(CollaboratorAlias $test)
    {
        $test->beADoubleOf(TestCase::class);
        
        $this->attach($test);
        
        $this->getTests()->shouldHaveCount(1);
        $this->getTests()->shouldContain($test);
    }
    
    /**
     * Test that multiple classes can be attacked by passing the attach function an array with tests.
     *
     * @param CollaboratorAlias $test1 This is a fake instance of the Test Abstract.
     * @param CollaboratorAlias $test2 This is an other fake instance of the Test Abstract.
     *
     * @return void
     */
    function it_should_allow_for_multiple_attachments(CollaboratorAlias $test1, CollaboratorAlias $test2)
    {
        $test1->beADoubleOf(TestCase::class);
        $test2->beADoubleOf(TestCase::class);
        
        $this->attach([$test1, $test2]);
        
        $this->has($test1)->shouldReturn(true);
        $this->has($test2)->shouldReturn(true);
    }
    
    /**
     * Test one test can be attached by just using a classname. This
     * test will automatically be loaded by the test suite.
     *
     * @return void
     */
    function it_can_attach_one_test_by_class_name()
    {
        $this->getTests()->shouldHaveCount(0);
        $this->attach([MockableTestCase::class]);
        
        $this->getTests()->shouldHaveCount(1);
        
        $this->getTests()->shouldHaveInstancesOfObjectWithType(MockableTestCase::class, 1);
    }
    
    /**
     * Test one test can be attached by just using a classname. This
     * test will automatically be loaded by the test suite.
     *
     * @return void
     */
    function it_can_attach_multiple_tests_by_class_name()
    {
        $this->getTests()->shouldHaveCount(0);
        $this->attach([MockableTestCase::class, MockableTestCase::class]);
        
        $this->getTests()->shouldHaveCount(2);
        
        $this->getTests()->shouldHaveInstancesOfObjectWithType(MockableTestCase::class, 2);
    }
    
    /**
     * Test that a test suite could run a single test.
     *
     * @return void
     */
    function it_should_run_a_single_test()
    {
        $test = MockableTestCase::create();
        
        $this->attach($test);
        $this->run()->shouldReturn(1);
        
        /**
         * Dont know if we need this but lets
         * do it.
         */
        $this->detach($test);
    }
    
    /**
     * Test that a test suite can run multiple tests.
     *
     * @return void
     */
    function it_should_run_a_multiple_tests()
    {
        $test1 = MockableTestCase::create();
        $test2 = MockableTestCase::create();
        
        $this->attach([$test1, $test2]);
        $this->run()->shouldReturn(2);
        
        /**
         * Don't know if we need this but lets
         * do it.
         */
        $this->detach($test1);
        $this->detach($test2);
    }
    
    /**
     * Test that a test score will be returned to the test suite
     * correctly.
     *
     * @return void
     */
    function it_should_score_five_with_one_test()
    {
        $test = MockableTestCase::createWith(5);
        $this->attach($test);
        
        $this->run(false);
        $this->getScore()->shouldReturn(5);
        
        /**
         * Don't know if we need this but lets
         * do it.
         */
        $this->detach($test);
    }
    
    /**
     * Testing that the score of multiple tests in a suite
     * will be summed together correctly.
     *
     * @return void
     */
    function it_should_score_eight_with_both_of_the_tests()
    {
        $test1 = MockableTestCase::createWith(5);
        $test2 = MockableTestCase::createWith(3);
        
        $this->attach([$test1, $test2]);
        
        $this->run(false);
        $this->getScore()->shouldReturn(8);
        
        /**
         * Don't know if we need this but lets
         * do it.
         */
        $this->detach($test1);
        $this->detach($test2);
    }
    
    /**
     * Test that scores on a Test Suite can be reset.
     *
     * @return void
     */
    function it_can_reset_it_self()
    {
        $test1 = MockableTestCase::createWith(5);
        $test2 = MockableTestCase::createWith(3);
        
        $this->attach([$test1, $test2]);
        
        $this->run(false);
        $this->getScore()->shouldReturn(8);
        
        /**
         * Don't know if we need this but lets
         * do it.
         */
        $this->detach($test1);
        $this->detach($test2);
        
        $this->reset();
        $this->getScore()->shouldReturn(0);
    }
    
    /**
     * Test the default score for a TestSuite is 0.
     *
     * @return void
     */
    function it_the_default_value_for_scores_is_0()
    {
        $this->getScore()->shouldBe(0);
    }
    
    /**
     * Test if beforeTest() exists.
     *
     * @return void
     */
    function it_should_have_function_beforetest()
    {
        $this->beforeTest();
    }
    
    /**
     * Test if afterTest() exists.
     *
     * @return void
     */
    function it_should_have_function_aftertest()
    {
        $this->afterTest();
    }
    
    /**
     * Test if the average function of the TestSuite works
     * correctly.
     *
     * @return false
     */
    function it_should_have_a_working_average_function()
    {
        $test1 = MockableTestCase::createWith(3);
        $test2 = MockableTestCase::createWith(3);
        $test3 = MockableTestCase::createWith(3);
        
        $this->attach([$test1, $test2, $test3])
            ->run(false);
        
        $this->average()->shouldReturn(3);
    }
}
