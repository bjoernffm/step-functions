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

    public function getValue($x) {
        foreach($this->stepFunctionList as $stepFunction) {
            if ($stepFunction->hasValue($x) === true) {
                return $stepFunction->getValue($x);
            }
        }

        throw new OutOfBoundsException('No function defined for '.$x);
    }
}
