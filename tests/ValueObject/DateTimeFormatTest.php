<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\ValueObject;

use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\ValueObject\DateTime */
final class DateTimeFormatTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::format
     */
    public function modify_works(
        string $expectedResult,
        DateTime $dateTime,
        string $format,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->format($format));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: DateTime,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-10-08T15:00:00+00:00',
                DateTime::fromString('2022-10-08 15:00:00'),
                \DateTimeInterface::ATOM,
            ],
            'format to date format' => [
                '2022-10-08',
                DateTime::fromString('2022-10-08 15:00:00'),
                'Y-m-d',
            ],
            'format time' => [
                '15:00:00',
                DateTime::fromString('2022-10-08 15:00:00'),
                'H:i:s',
            ],
        ];
    }
}
