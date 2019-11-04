<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use bjoernffm\stepFunctions\StepFunction;
use bjoernffm\stepFunctions\Interpolator;

final class InterpolatorTest extends TestCase
{
    public function testInterpolatorBasics(): void
    {
        $first = new StepFunction(0, 1, function($x) { return $x; });
        $second = new StepFunction(1, 2, function($x) { return -1*$x+2; });

        $interpolator = new Interpolator();
        $interpolator->add($first);
        $interpolator->add($second);

        $this->assertEquals(0, $interpolator->getValue(0));
        $this->assertEquals(0.5, $interpolator->getValue(0.5));
        $this->assertEquals(1, $interpolator->getValue(1));
        $this->assertEquals(0.5, $interpolator->getValue(1.5));
        $this->assertEquals(0, $interpolator->getValue(2));
    }

    public function testInterpolatorFail(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('No function defined for -1');

        $first = new StepFunction(0, 1, function($x) { return $x; });
        $second = new StepFunction(1, 2, function($x) { return -1*$x+2; });

        $interpolator = new Interpolator();
        $interpolator->add($first);
        $interpolator->add($second);

        $this->assertEquals(null, $interpolator->getValue(-1));
    }
}