<?php

namespace Redbox\Cli\Tests;

use PHPUnit\Framework\TestCase;
use Redbox\Cli\Cli;

/**
 * @@coversDefaultClass  \Redbox\Cli\Arguments\Arguments
 */
class ArgumentsTest extends TestCase
{
    /**
     * dataProvider for the testUsageLineIsCorrect() test
     *
     * @return array
     */
    public function usageProvider()
    {
        global $argv;
        $cmd = $argv[0];

        return [
            /* Test short prefix */
            [
                [
                    'user' => [
                        'prefix' => 'u',
                        'longPrefix' => 'user',
                        'description' => 'Username',
                        'defaultValue' => 'me_myself_i',
                        'required' => true,
                    ],
                ],
                "Usage: ".$cmd." [-u user, --user user, (default: me_myself_i)]\n\nRequired Arguments:\n\t-u user, --user user, (default: me_myself_i)\n\t\tUsername\n\n",
            ],

            /* Test required and optional arguments */
            [
                [
                    'user' => [
                        'prefix' => 'u',
                        'longPrefix' => 'user',
                        'description' => 'Username',
                        'defaultValue' => 'me_myself_i',
                        'required' => true,
                    ],
                    'iterations' => [
                        'prefix' => 'i',
                        'longPrefix' => 'iterations',
                        'description' => 'Number of iterations',
                        'castTo' => 'int',
                    ],
                ],
                "Usage: ".$cmd." [-u user, --user user, (default: me_myself_i)] [-i iterations, --iterations iterations]\n\nRequired Arguments:\n\t-u user, --user user, (default: me_myself_i)\n\t\tUsername\n\nOptional Arguments:\n\t-i iterations, --iterations iterations\n\t\tNumber of iterations\n\n",
            ],
        ];
    }

    /**
     * This test will fail because the test did not set the require -u or --user
     * argument.
     *
     * @expectedException        \Exception
     * @expectedExceptionMessage The following arguments are required: user.
     * @coversDefaultClass       \Redbox\Cli\Parser
     */
    public function testRequiredArgumentIsNotFound()
    {
        $cli = new Cli();
        $cli->arguments->add([
            'user' => [
                'prefix' => 'u',
                'longPrefix' => 'user',
                'description' => 'Username',
                'required' => true,
            ],
        ]);
        $cli->arguments->parse();
    }

    /**
     * Test that a required argument has the correct values. This might look
     * silly but it is required to be tested.
     */
    public function testRequiredParameterHasCorrectValue()
    {
        $cli = new Cli();
        $cli->arguments->add([
            'q' => [
                'prefix' => 'q',
                'description' => 'Set php values',
                'required' => true,
            ],
        ]);

        $cli->arguments->parse();
        $this->assertEquals($cli->arguments->get('q'), 'brownfox');
    }

    /**
     * Test if a parameter is passed with a different value then the default value that
     * its different from the default value for this parameter.
     */
    public function testArgumentIsNotDefaultValue()
    {
        $cli = new Cli();
        $cli->arguments->add([
            'q' => [
                'prefix' => 'q',
                'description' => 'Make the code go eek!',
                'defaultValue' => 'eek',
            ],
        ]);
        $cli->arguments->parse();
        $this->assertFalse($cli->arguments->hasDefaultValue('q'));
    }

    /**
     * This test will ensure that a default value will be set even if it was not passed to the
     * commandline and that Redbox\Cli\Arguments\Arguments\Manager::hasDefaultValue will inform us that the default value has been set.
     */
    public function test_if_default_value_isset_when_no_argument_is_passed()
    {
        $cli = new Cli();

        /*
         * Setup the rules of engagement
         */
        $cli->arguments->add([
            'targetpath' => [
                'prefix' => 't',
                'longPrefix' => 'targetpath',
                'description' => 'Path',
                'defaultValue' => '/var/log',
            ],
        ]);
        $cli->arguments->parse();
        $this->assertEquals($cli->arguments->get('targetpath'), '/var/log');
        $this->assertTrue($cli->arguments->hasDefaultValue('targetpath'));
    }

    /**
     * Test that Arguments\Argument::usageLine() returns the correct layout.
     *
     * @dataProvider usageProvider
     * @param array $args
     * @param string $expected
     */
    public function testUsageLineIsCorrect($args = [], $expected = '')
    {
        $this->expectOutputString($expected);

        $cli = new Cli();
        $cli->arguments->add($args);
        $cli->arguments->parse();
        $cli->arguments->usage();
    }
}