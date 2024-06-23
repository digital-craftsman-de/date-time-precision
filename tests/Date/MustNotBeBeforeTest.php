<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Date;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsBefore;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsBefore;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Date */
final class MustNotBeBeforeTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeBefore
     */
    public function must_not_be_before_works(
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

        $date->mustNotBeBefore(
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
                DateIsBefore::class,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-09'),
                null,
            ],
            'custom exception' => [
                CustomDateIsBefore::class,
                Date::fromString('2022-10-08'),
                Date::fromString('2022-10-09'),
                static fn () => new CustomDateIsBefore(),
            ],
        ];
    }
}
