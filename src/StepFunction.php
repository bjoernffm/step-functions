<?php
declare(strict_types = 1);

namespace bjoernffm\stepFunctions;

class StepFunction
{
    protected $start;
    protected $end;
    protected $function;

    public function __construct(float $start, float $end, callable $function)
    {
        $this->start = $start;
        $this->end = $end;
        $this->function = $function;
    }

    public function getStart(): float
    {
        return $this->start;
    }

    public function getEnd(): float
    {
        return $this->end;
    }

    public function getFunction(): callable
    {
        return $this->function;
    }

    public function getValue(float $input): float
    {
        $function = $this->function;
        return $function($input);
    }

    public function hasValue(float $input): bool
    {
        if ($this->start <= $input and $input <= $this->end) {
            return true;
        }

        return false;
    }
}