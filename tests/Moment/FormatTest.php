<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class FormatTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function format_works(
        string $expectedResult,
        Moment $dateTime,
        string $format,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->format($format));
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: Moment,
     *   2: string,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'format to atom' => [
                '2022-10-08T15:00:00+00:00',
                Moment::fromString('2022-10-08 15:00:00'),
                \DateTimeInterface::ATOM,
            ],
            'format to date format' => [
                '2022-10-08',
                Moment::fromString('2022-10-08 15:00:00'),
                'Y-m-d',
            ],
            'format time' => [
                '15:00:00',
                Moment::fromString('2022-10-08 15:00:00'),
                'H:i:s',
            ],
        ];
    }
}
