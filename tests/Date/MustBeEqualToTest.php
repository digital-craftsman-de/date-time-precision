<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsNotEqual;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsNotEqual;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class MustBeEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustBeEqualTo
     */
    public function must_be_equal_to_works(
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

        $date->mustBeEqualTo(
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
                Date::fromString('2022-10-08'),
                null,
            ],
            'default exception' => [
                DateIsNotEqual::class,
                Date::fromString('2022-10-07'),
                Date::fromString('2022-10-08'),
                null,
            ],
            'custom exception' => [
                CustomDateIsNotEqual::class,
                Date::fromString('2022-10-07'),
                Date::fromString('2022-10-08'),
                static fn () => new CustomDateIsNotEqual(),
            ],
        ];
    }
}
