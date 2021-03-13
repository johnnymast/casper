<?php
namespace Redbox\Cli\Arguments;

/**
 * The manager class is the main interface for interacting
 * with the arguments part of Redbox-cli.
 *
 * @package Redbox\Cli\Arguments
 */
class Manager
{
    /**
     * An array of arguments passed to the program.
     *
     * @var array $arguments
     */
    protected $arguments = [];

    /**
     * An array containing the parsed values.
     *
     * @var array $values;
     */
    protected $values = [];

    /**
     * An array that contains all the default values
     * that are passed to the manager.
     *
     * @var array
     */
    protected $defaultvalues = [];

    /**
     * @var \Redbox\Cli\Arguments\Parser
     */
    protected $parser;

    /**
     * @var \Redbox\Cli\Arguments\Filter
     */
    protected $filter;

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->parser = new Parser($this);
        $this->filter = new Filter;
    }

    /**
     * Prints out the usage message to the user.
     * @return void
     */
    public function usage()
    {
        $requiredArguments = $this->filter->required();
        $optionalArguments = $this->filter->optional();
        $allArguments      = array_merge($requiredArguments, $optionalArguments);
        $command           = $this->parser->getCommand();
        $args              = array();

        $num_required      = count($requiredArguments);
        $num_optional      = count($optionalArguments);

        echo "Usage: ".$command." ";

        foreach ($allArguments as $argument) {
            /** @var Argument $argument */
            $args[] = '['.$argument->usageInfo().']';
        }

        $args = implode(' ', $args);
        echo $args."\n\n";

        if ($num_required) {
            echo "Required Arguments:\n";
            foreach ($requiredArguments as $argument) {
                echo $argument->usageLine();
            }
        }

        if ($num_required && $num_optional) {
            echo "\n";
        }

        if ($num_optional) {
            echo "Optional Arguments:\n";
            foreach ($optionalArguments as $argument) {
                echo $argument->usageLine();
            }
        }

        echo "\n";
    }

    /**
     * Determine if a given argument has a default value or not.
     * One thing to note is that if having no info about the argument
     * (being a key in xx is not set) we will return false as well.
     *
     * @param $argument
     * @return boolean
     */
    public function hasDefaultValue($argument)
    {
        if (isset($this->defaultvalues[$argument]) === true) {
            return true;
        }
        return false;
    }

    /**
     * Set if a argument has defaulted to the default argument or not.
     *
     * @param string $argument
     * @param bool $default
     */
    public function setHasDefaultValue($argument = "", $default = false)
    {
        $this->defaultvalues[$argument] = $default;
    }

    /**
     * Set a parsed argument.
     *
     * @param $argument
     * @param $value
     */
    public function set($argument, $value)
    {
        $this->values[$argument] = $value;
    }

    /**
     * Return any set argument or false if the argument is unknown.
     *
     * @param $argument
     * @return bool
     */
    public function get($argument)
    {
        if (isset($this->values[$argument]) === false) {
            return false;
        }
        return $this->values[$argument];
    }

    /**
     * Return all given arguments.
     *
     * @return array
     */
    public function all()
    {
        return $this->arguments;
    }

    /**
     * Add arguments to the list, this could be one or an array of arguments.
     *
     * @param $argument
     * @param array $options
     * @throws \Exception
     */
    public function add($argument, $options = [])
    {
        if (is_array($argument) === true) {
            $this->addMany($argument);
            return;
        }

        $options['name'] = $argument;
        $arg = new Argument($options);

        $this->arguments[$argument] = $arg;
    }

    /**
     * This function will be called if we can add an array of commandline arguments
     * to parse.
     *
     * @param array $arguments
     * @throws \Exception
     */
    protected function addMany(array $arguments = [])
    {
        foreach ($arguments as $name => $options) {
            $this->add($name, $options);
        }
    }

    /**
     * Go ahead and parse the arguments given.
     *
     * @throws \Exception
     */
    public function parse()
    {
        $this->parser->setFilter($this->filter, $this->all());
        $this->parser->parse();
    }
}