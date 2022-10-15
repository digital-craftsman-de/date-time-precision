<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Date */
final class DateFormatTest extends TestCase
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
        Date $date,
        string $format,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $date->format($format));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: Date,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-10-08T00:00:00+00:00',
                Date::fromString('2022-10-08'),
                \DateTimeInterface::ATOM,
            ],
            'format to date format' => [
                '2022-10-08',
                Date::fromString('2022-10-08'),
                'Y-m-d',
            ],
            'format time' => [
                '00:00:00',
                Date::fromString('2022-10-08'),
                'H:i:s',
            ],
        ];
    }
}
