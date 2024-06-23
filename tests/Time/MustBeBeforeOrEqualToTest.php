<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Exception\TimeIsNotBeforeOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomTimeIsNotBeforeOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class MustBeBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustBeBeforeOrEqualTo
     */
    public function must_be_before_or_equal_to_works(
        ?string $expectedResult,
        Time $date,
        Time $comparator,
        ?callable $otherwiseThrow,
    ): void {
        // -- Act & Assert
        if ($expectedResult !== null) {
            $this->expectException($expectedResult);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $date->mustBeBeforeOrEqualTo(
            $comparator,
            $otherwiseThrow,
        );
    }

    /**
     * @return array<string, array{
     *   0: ?string,
     *   1: Time,
     *   2: Time,
     *   3: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'without exception' => [
                null,
                Time::fromString('14:00:00'),
                Time::fromString('15:00:00'),
                null,
            ],
            'default exception' => [
                TimeIsNotBeforeOrEqualTo::class,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
                null,
            ],
            'custom exception' => [
                CustomTimeIsNotBeforeOrEqualTo::class,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
                static fn () => new CustomTimeIsNotBeforeOrEqualTo(),
            ],
        ];
    }
}
