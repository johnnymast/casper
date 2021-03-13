<?php
require 'autoload.php';

use Redbox\Cli\Cli as CLI;

/**
 * To see the different results run this script like.
 *
 * $ php ./defaultvalue.php
 * OR
 * php ./defaultvalue.php -t=X
 */
try {
    $cli = new CLI;

    /**
     * Setup the rules of engagement
     */
    $cli->arguments->add([
        'targetpath' => [
            'prefix'       => 't',
            'longPrefix'   => 'targetpath',
            'description'  => 'Path',
            'defaultValue' => '/var/log',
            'required'     => true,
        ]
    ]);

    /**
     * We need to tell the parser to start.
     */
    $cli->arguments->parse();

    /**
     * If we don't get an exception of us missing things we can handle stuff.
     */
    echo "The default value for path is: ".$cli->arguments->get('targetpath')."\n";

} catch (Exception $e) {
    /**
     * Print how to use the script
     */
    $cli->arguments->usage();
}
