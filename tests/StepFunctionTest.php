<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use bjoernffm\stepFunctions\StepFunction;

final class StepFunctionTest extends TestCase
{
    public function testStepFunctionBasics(): void
    {
        $sf = new StepFunction(1, 2.0, function($x) { return 2*$x; });
        $this->assertEquals(1, $sf->getFrom());
        $this->assertEquals(2.0, $sf->getTo());

        $function = $sf->getFunction();
        $this->assertEquals(0, $function(0));
        $this->assertEquals(1, $function(0.5));
        $this->assertEquals(2, $function(1));
        $this->assertEquals(20, $function(10));
        $this->assertEquals(-1, $function(-0.5));
        $this->assertEquals(-2, $function(-1));
        $this->assertEquals(-20, $function(-10));
    }

    public function testStepFunctionRanges(): void
    {
        $sf = new StepFunction(1, 2, function($x) { return 2*$x; });

        $this->assertEquals(true, $sf->hasValue(1));
        $this->assertEquals(true, $sf->hasValue(1.5));
        $this->assertEquals(true, $sf->hasValue(1.99999999999999999));
        $this->assertEquals(true, $sf->hasValue(2));
        $this->assertEquals(true, $sf->hasValue(M_LOG2E));
        $this->assertEquals(false, $sf->hasValue(2.00000000000001));
        $this->assertEquals(false, $sf->hasValue(3));
        $this->assertEquals(false, $sf->hasValue(0));
        $this->assertEquals(false, $sf->hasValue(-10));
        $this->assertEquals(false, $sf->hasValue(M_PI));
        $this->assertEquals(false, $sf->hasValue(INF));
        $this->assertEquals(false, $sf->hasValue(-INF));
    }

    public function testStepFunctionRangesAdvanced(): void
    {
        $sf = new StepFunction(-INF, INF, function($x) { return $x; });
        $this->assertEquals(true, $sf->hasValue(-INF));
        $this->assertEquals(true, $sf->hasValue(-1.3));
        $this->assertEquals(true, $sf->hasValue(0));
        $this->assertEquals(true, $sf->hasValue(1.3));
        $this->assertEquals(true, $sf->hasValue(INF));

        $sf = new StepFunction(-INF, 0, function($x) { return $x; });
        $this->assertEquals(true, $sf->hasValue(-INF));
        $this->assertEquals(true, $sf->hasValue(-1.3));
        $this->assertEquals(true, $sf->hasValue(0));
        $this->assertEquals(false, $sf->hasValue(1.3));
        $this->assertEquals(false, $sf->hasValue(INF));

        $sf = new StepFunction(0, INF, function($x) { return $x; });
        $this->assertEquals(false, $sf->hasValue(-INF));
        $this->assertEquals(false, $sf->hasValue(-1.3));
        $this->assertEquals(true, $sf->hasValue(0));
        $this->assertEquals(true, $sf->hasValue(1.3));
        $this->assertEquals(true, $sf->hasValue(INF));
    }
}