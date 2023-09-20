<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Month;

use DigitalCraftsman\DateTimeParts\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Month */
final class MonthFormatTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::format
     * @covers ::toDateTimeImmutable
     */
    public function format_works(
        string $expectedResult,
        Month $date,
        string $format,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $date->format($format));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: Month,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-10-01T00:00:00+00:00',
                Month::fromString('2022-10'),
                \DateTimeInterface::ATOM,
            ],
            'format to date format' => [
                '2022-10-01',
                Month::fromString('2022-10'),
                'Y-m-d',
            ],
            'format time' => [
                '00:00:00',
                Month::fromString('2022-10'),
                'H:i:s',
            ],
        ];
    }
}
