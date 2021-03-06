<?php

declare(strict_types=1);

use bjoernffm\stepFunctions\Interpolator;
use bjoernffm\stepFunctions\StepFunction;
use PHPUnit\Framework\TestCase;

final class InterpolatorTest extends TestCase
{
    public function testInterpolatorBasics(): void
    {
        $first = new StepFunction(0, 1, function ($input) {
            return $input;
        });
        $second = new StepFunction(1, 2, function ($input) {
            return -1 * $input + 2;
        });

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

        $first = new StepFunction(0, 1, function ($input) {
            return $input;
        });
        $second = new StepFunction(1, 2, function ($input) {
            return -1 * $input + 2;
        });

        $interpolator = new Interpolator();
        $interpolator->add($first);
        $interpolator->add($second);

        $this->assertEquals(null, $interpolator->getValue(-1));
    }
}
