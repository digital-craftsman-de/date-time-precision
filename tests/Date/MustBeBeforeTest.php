<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsNotBefore;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsNotBefore;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class MustBeBeforeTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustBeBefore
     */
    public function must_be_before_works(
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

        $date->mustBeBefore(
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
                DateIsNotBefore::class,
                Date::fromString('2022-10-09'),
                Date::fromString('2022-10-08'),
                null,
            ],
            'custom exception' => [
                CustomDateIsNotBefore::class,
                Date::fromString('2022-10-09'),
                Date::fromString('2022-10-08'),
                static fn () => new CustomDateIsNotBefore(),
            ],
        ];
    }
}
