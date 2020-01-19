# Step Functions

![GitHub](https://img.shields.io/github/license/bjoernffm/step-functions) ![GitHub release (latest by date)](https://img.shields.io/github/v/release/bjoernffm/step-functions) ![GitHub top language](https://img.shields.io/github/languages/top/bjoernffm/step-functions) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/3001bb4b742c45d69db1ce6c3171b28e)](https://www.codacy.com/manual/bjoernffm/step-functions)
[![StyleCI](https://github.styleci.io/repos/219455050/shield?branch=master&style=flat)](https://github.styleci.io/repos/219455050)

**Step Functions** is a library which offers implementation of step functions. Define one or multiple functions, define the bounds where they are in use and this library will interpolate between the functions.

## Installation

This library is provided as [Composer package](https://packagist.org/packages/bjoernffm/step-functions). To install it, simply execute the folowing command:

```plain
composer require bjoernffm/step-functions
```

**Note:** This library requires **PHP 7.2**.

## Usage

The simplest usage that will mostly fulfill your needs is to define one or more functions and add them to an interpolator instance:

```php
<?php

use bjoernffm\stepFunctions\StepFunction;
use bjoernffm\stepFunctions\Interpolator;

require 'vendor/autoload.php';

$first = new StepFunction(0, 1, function($input) { return $input; });
$second = new StepFunction(1, 2, function($input) { return -1*$input+2; });

$interpolator = new Interpolator();
$interpolator->add($first);
$interpolator->add($second);

echo $interpolator->getValue(0); // output 0
echo $interpolator->getValue(0.5); // output 0.5
echo $interpolator->getValue(1); // output 1
echo $interpolator->getValue(1.5); // output 0.5
echo $interpolator->getValue(2); // output 0
```

## Contributing

Do you want to help improving this project? Simply *fork* it and post a pull request. You can do everything on your own, you don't need to ask if you can, just do all the awesome things you want!

This project is published under [Apache-2.0 license](https://github.com/bjoernffm/step-functions/blob/master/LICENSE).
