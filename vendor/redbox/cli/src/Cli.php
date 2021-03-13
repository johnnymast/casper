<?php
namespace Redbox\Cli;
use Redbox\Cli\Arguments\Manager as ArgumentManager;

class Cli
{
    /**
     * An instance of the Argument Manager class
     *
     * @var \Redbox\Cli\Arguments\Manager
     */
    public $arguments;

    public function __construct()
    {
        $this->setManager(new ArgumentManager());
    }

    /**
     * Set the manager for handling arguments
     *
     * @param \Redbox\Cli\Arguments\Manager $manager
     */
    public function setManager(ArgumentManager $manager)
    {
        $this->arguments = $manager;
    }
}