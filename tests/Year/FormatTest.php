<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
final class FormatTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function format_works(
        string $expectedResult,
        Year $date,
        string $format,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $date->format($format));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: Year,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-01-01T00:00:00+00:00',
                new Year(2022),
                \DateTimeInterface::ATOM,
            ],
            'format to date format' => [
                '2022-01-01',
                new Year(2022),
                'Y-m-d',
            ],
            'format time' => [
                '00:00:00',
                new Year(2022),
                'H:i:s',
            ],
        ];
    }
}
