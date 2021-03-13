<?php
namespace Redbox\Cli\Arguments;

/**
 * Okay its hard to explain this one you dot not know array_filter.
 * What it does (this class)
 *
 * @package Redbox\Cli\Arguments
 */
class Filter
{
    /**
     * An array of arguments passed to the program.
     *
     * @var Argument[] $arguments
     */
    protected $arguments = [];

    /**
     * Set the arguments to filter.
     *
     * @param array $arguments
     */
    public function setArguments($arguments = [])
    {
        $this->arguments = $arguments;
    }

    /**
     * Callback function to check if the argument has a short prefix.
     *
     * @param $argument
     * @return mixed
     */
    public function hasShortPrefix($argument)
    {
        return ($argument->prefix);
    }

    /**
     * Callback function to check if the argument has a long prefix.
     *
     * @param $argument
     * @return mixed
     */
    public function hasLongPrefix($argument)
    {
        return ($argument->prefix);
    }

    /**
     * Callback function to check if the argument is required.
     *
     * @param $argument
     * @return mixed
     */
    protected function isRequired($argument)
    {
        return $argument->required;
    }

    /**
     * Callback function to check if the argument does not had the required option.
     *
     * @param $argument
     * @return bool
     */
    protected function isOptional($argument)
    {
        return ($argument->required == false);
    }

    /**
     * Return all required arguments, these are arguments with required => true,
     *
     * @return Argument[] arguments with arguments set required to true
     */
    public function required()
    {
        return $this->filterArguments(['isRequired']);
    }

    /**
     * Return all arguments without required => true.
     *
     * @return Argument[] arguments with arguments set required to false
     */
    public function optional()
    {
        return $this->filterArguments(['isOptional']);
    }

    /**
     * Return an array with short prefixes.
     *
     * @return Argument[] arguments with a short prefix (e.x -u)
     */
    public function withShortPrefix()
    {
        return $this->filterArguments(['hasShortPrefix']);
    }

    /**
     * Return an array with long prefixes
     *
     * @return Argument[] required arguments (e.x --user)
     */
    public function withLongPrefix()
    {
        return $this->filterArguments(['hasLongPrefix']);
    }

    /**
     * This function will do the actual filtering. Call backs for array_filter
     * will be in this function for example isRequired.
     *
     * @param array $filters
     * @return array
     */
    protected function filterArguments($filters = [])
    {
        $arguments = $this->arguments;

        foreach ($filters as $filter) {
            $arguments = array_filter($arguments, [$this, $filter]);
        }
        return array_values($arguments);
    }
}