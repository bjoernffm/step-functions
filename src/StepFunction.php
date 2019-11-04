<?php
declare(strict_types = 1);

namespace bjoernffm\stepFunctions;

class StepFunction
{
    protected $from;
    protected $to;
    protected $function;

    public function __construct(float $from, float $to, callable $function)
    {
        $this->from = $from;
        $this->to = $to;
        $this->function = $function;
    }

    public function getFrom(): float
    {
        return $this->from;
    }

    public function getTo(): float
    {
        return $this->to;
    }

    public function getFunction(): callable
    {
        return $this->function;
    }

    public function getValue(float $x): float
    {
        $function = $this->function;
        return $function($x);
    }

    public function hasValue(float $x): bool
    {
        if ($this->from <= $x and $x <= $this->to) {
            return true;
        } else {
            return false;
        }
    }
}