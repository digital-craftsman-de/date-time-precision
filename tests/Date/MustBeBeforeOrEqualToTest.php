<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsNotBeforeOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsNotBeforeOrEqualTo;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
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
        Date $date,
        Date $comparator,
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
     *   1: Date,
     *   2: Date,
     *   3: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'without exception' => [
                null,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-09'),
                null,
            ],
            'default exception' => [
                DateIsNotBeforeOrEqualTo::class,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-07'),
                null,
            ],
            'custom exception' => [
                CustomDateIsNotBeforeOrEqualTo::class,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-07'),
                static fn () => new CustomDateIsNotBeforeOrEqualTo(),
            ],
        ];
    }
}
