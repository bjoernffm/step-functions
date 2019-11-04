<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use bjoernffm\stepFunctions\StepFunction;

final class StepFunctionTest extends TestCase
{
    public function testStepFunctionBasics(): void
    {
        $function = new StepFunction(1, 2.0, function($x) { return 2*$x; });
        $this->assertEquals(1, $function->getStart());
        $this->assertEquals(2.0, $function->getEnd());

        $function = $function->getFunction();
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
        $function = new StepFunction(1, 2, function($x) { return 2*$x; });

        $this->assertEquals(true, $function->hasValue(1));
        $this->assertEquals(true, $function->hasValue(1.5));
        $this->assertEquals(true, $function->hasValue(1.99999999999999999));
        $this->assertEquals(true, $function->hasValue(2));
        $this->assertEquals(true, $function->hasValue(M_LOG2E));
        $this->assertEquals(false, $function->hasValue(2.00000000000001));
        $this->assertEquals(false, $function->hasValue(3));
        $this->assertEquals(false, $function->hasValue(0));
        $this->assertEquals(false, $function->hasValue(-10));
        $this->assertEquals(false, $function->hasValue(M_PI));
        $this->assertEquals(false, $function->hasValue(INF));
        $this->assertEquals(false, $function->hasValue(-INF));
    }

    public function testStepFunctionRangesAdvanced(): void
    {
        $function = new StepFunction(-INF, INF, function($x) { return $x; });
        $this->assertEquals(true, $function->hasValue(-INF));
        $this->assertEquals(true, $function->hasValue(-1.3));
        $this->assertEquals(true, $function->hasValue(0));
        $this->assertEquals(true, $function->hasValue(1.3));
        $this->assertEquals(true, $function->hasValue(INF));

        $function = new StepFunction(-INF, 0, function($x) { return $x; });
        $this->assertEquals(true, $function->hasValue(-INF));
        $this->assertEquals(true, $function->hasValue(-1.3));
        $this->assertEquals(true, $function->hasValue(0));
        $this->assertEquals(false, $function->hasValue(1.3));
        $this->assertEquals(false, $function->hasValue(INF));

        $function = new StepFunction(0, INF, function($x) { return $x; });
        $this->assertEquals(false, $function->hasValue(-INF));
        $this->assertEquals(false, $function->hasValue(-1.3));
        $this->assertEquals(true, $function->hasValue(0));
        $this->assertEquals(true, $function->hasValue(1.3));
        $this->assertEquals(true, $function->hasValue(INF));
    }
}