<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Time;

use DigitalCraftsman\DateTimePrecision\Exception\TimeIsEqualTo;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomTimeIsEqualTo;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Time */
final class MustNotBeEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeEqualTo
     */
    public function must_not_be_equal_to_works(
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

        $date->mustNotBeEqualTo(
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
                Time::fromString('16:00:00'),
                Time::fromString('15:00:00'),
                null,
            ],
            'default exception' => [
                TimeIsEqualTo::class,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
                null,
            ],
            'custom exception' => [
                CustomTimeIsEqualTo::class,
                Time::fromString('15:00:00'),
                Time::fromString('15:00:00'),
                static fn () => new CustomTimeIsEqualTo(),
            ],
        ];
    }
}
