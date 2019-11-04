<?php

namespace bjoernffm\stepFunctions;

use OutOfBoundsException;

class Interpolator
{
    protected $stepFunctionList = [];

    public function add(StepFunction $stepFunction)
    {
        $this->stepFunctionList[] = $stepFunction;
    }

    public function getValue($input) {
        foreach($this->stepFunctionList as $stepFunction) {
            if ($stepFunction->hasValue($input) === true) {
                return $stepFunction->getValue($input);
            }
        }

        throw new OutOfBoundsException('No function defined for '.$input);
    }
}
