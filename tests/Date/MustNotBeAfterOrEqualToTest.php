<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsAfterOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsAfterOrEqualTo;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
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

        $date->mustNotBeAfterOrEqualTo(
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
                DateIsAfterOrEqualTo::class,
                Date::fromString('2022-10-09'),
                Date::fromString('2022-10-08'),
                null,
            ],
            'custom exception' => [
                CustomDateIsAfterOrEqualTo::class,
                Date::fromString('2022-10-09'),
                Date::fromString('2022-10-08'),
                static fn () => new CustomDateIsAfterOrEqualTo(),
            ],
        ];
    }
}
