<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Exception\TimeIsAfterOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomTimeIsAfterOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class MustNotBeAfterOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeAfterOrEqualTo
     */
    public function must_not_be_after_or_equal_to_works(
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

        $date->mustNotBeAfterOrEqualTo(
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
                TimeIsAfterOrEqualTo::class,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
                null,
            ],
            'custom exception' => [
                CustomTimeIsAfterOrEqualTo::class,
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
                static fn () => new CustomTimeIsAfterOrEqualTo(),
            ],
        ];
    }
}
