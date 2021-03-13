![redbox-logo-klein](https://cloud.githubusercontent.com/assets/121194/12361779/5af96e52-bbc0-11e5-91b0-2b7afbc1e5cc.png)

[![Build Status](https://travis-ci.org/johnnymast/redbox-cli.svg)](https://travis-ci.org/johnnymast/redbox-cli) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-cli/?branch=master)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact%20author)](https://twitter.com/intent/tweet?text=@mastjohnny)

# redbox-cli
This is a command line parser based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). We share a lot of similarities but i desided to take the getopt route and downgrade the number of lines in the code by 1/4 of the original size.


## Howto use the package
Look in the examples folder for basic [examples](examples) of how to use the package.

## Installation

Using [composer](https://packagist.org/packages/redbox/cli):

```bash
$ composer require redbox-cli
```
## Requirements

The following versions of PHP are supported by this version.

+ PHP >= 5.4

## Unit Testing

With the new 1.2 release we increased the test ratio from 64% in previous versions to 95% and that is making me proud. Also with the new release i have found a way to unit test the core component of this package (getopt(). While doing this we can make sure your implementation
of Redbox-cli will run like a sunshine with any of your projects. If you want a little of what our new tests cover that was not possible before, checkout our [examples](examples) directory for some great examples on how to use this great package.

  
  
## Author

This package is created and maintained by [Johnny Mast](https://github.com/johnnymast) but it was based on [Climate](https://github.com/thephpleague/climate)  by [Joe Tannenbaum](https://github.com/joetannenbaum). For feature requests and suggestions
you could consider sending me an e-mail or fill out an [issue](https://github.com/johnnymast/redbox-cli/issues).

## License

Redbox-cli is released under the MIT public license.

[LICENSE](LICENSE.md)
 
