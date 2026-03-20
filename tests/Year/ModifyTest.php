<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
final class ModifyTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function modify_works(
        Year $expectedResult,
        Year $month,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertEquals($expectedResult, $month->modify($modifier));
    }

    /**
     * @return array<string, array{
     *   0: Year,
     *   1: Year,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'subtract one year' => [
                Year::fromString('2021'),
                Year::fromString('2022'),
                '- 1 year',
            ],
            'add one year' => [
                Year::fromString('2023'),
                Year::fromString('2022'),
                '+ 1 year',
            ],
            'stupid but valid modification with one day' => [
                Year::fromString('2022'),
                Year::fromString('2022'),
                '+ 1 day',
            ],
        ];
    }
}
