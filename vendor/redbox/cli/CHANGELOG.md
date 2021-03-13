## 1.2.1 2018-30-10

* Fixed a bug where in php 7+ the word Object was reserved. Fixing #24
* Bumped PHPUnit to version 7. Fixing #25 
* Updated the README, informing about the php versions supported.
* Updated the phpunit.xml file.

## 1.2 2015-23-12

* Fixed a typo in examples/basic.php
* Added a logo to README.md
* Updated the markdown on the README.md file
* Improved code comments
* Finally we can debug getopt() parser.php
* Improved code coverage from 64% to 95%
* Removed composer.lock from repo
* Decreased code complexity in Parse.php
* Added tests for Arguments\Argument
* Improved code quality by loads
* Added an extra space between the script name and the usage in Arguments\Manager::usage();
* Added an extra newline after the last line in Arguments\Manager::usage()
* Updated examples comments
* Fixed a load of overall grammar errors
* Did speed up the code like 40%
* Fixed all open issues for milestone 1.2
* Fixed coding style in the Filter class
* Fixed coding style in the Object Hydrate class
* Fixed coding style in the Cli class
* Fixed spelling in README.md
* Updated the Unit testing section in README.md
* Improved on the basic wording of the README.md file


## 1.1.1 2015-19-12

* Updated the CHANGELOG.md to also contain the missing 1.0 changelog entry. fixed #3
* Added a new line to Redbox\Cli\Arguments::usage() so it would look better. fixed #2 
* Added Redbox\Cli\Manager::hasDefaultValue() so you know if the default value was set #fixed #5
* Removed the comment about default arguments and if its a good thing in Redbox\Cli\Arguments\Parser::parse()
* Changed the comments in examples/defaultvalue.php and examples/default.php to mimic the testcase better.
* Added examples/hasdefaultvalue.php to show the Redbox\Cli\Manager::hasDefaultValue() fature.
* Redbox\Cli\Arguments::get() now returns false if the argument is unknown.
* Removed TestBase.php as it was an unused class.
* Added more tests, also for the Manager class.
* Cleaned up the code and added more comments.
* Commented on all functions specially in Manager.php.
* Fixed all the open issues for the 1.1.1 milestone.

## 1.1 - 2015-13-12 

This is it the first non zero release of redbox-cli is here.

## 1.0 - 2015-12-12

This is version 1.0. I'm committing all over the place because i didn't add any tests yet. This is soon to change.
As with any software its better to wait for the 1.1 release.

  