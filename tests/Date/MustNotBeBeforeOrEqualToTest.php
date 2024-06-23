<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsBeforeOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsBeforeOrEqualTo;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class MustNotBeBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeBeforeOrEqualTo
     */
    public function must_not_be_before_or_equal_to_works(
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

        $date->mustNotBeBeforeOrEqualTo(
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
                Date::fromString('2022-10-09'),
                Date::fromString('2022-10-08'),
                null,
            ],
            'default exception' => [
                DateIsBeforeOrEqualTo::class,
                Date::fromString('2022-10-07'),
                Date::fromString('2022-10-08'),
                null,
            ],
            'custom exception' => [
                CustomDateIsBeforeOrEqualTo::class,
                Date::fromString('2022-10-07'),
                Date::fromString('2022-10-08'),
                static fn () => new CustomDateIsBeforeOrEqualTo(),
            ],
        ];
    }
}
