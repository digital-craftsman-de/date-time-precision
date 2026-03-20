<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class IsAtMidnightTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function is_at_midnight_works(
        bool $expectedResult,
        Moment $dateTime,
    ): void {
        // -- Act & Assert
        self::assertSame($expectedResult, $dateTime->isAtMidnight());
    }

    /**
     * @return array<string, array{
     *   0: bool,
     *   1: Moment,
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'midnight at 00:00:00' => [
                true,
                Moment::fromString('2022-10-08 00:00:00'),
            ],
            'not midnight at 01:00:00' => [
                false,
                Moment::fromString('2022-01-01 01:00:00'),
            ],
            'not midnight on time with milliseconds' => [
                false,
                Moment::fromString('2022-10-08 00:00:00.023423'),
            ],
            'midnight in specific timezone' => [
                true,
                Moment::fromStringInTimeZone('2022-10-08 00:00:00', new \DateTimeZone('Europe/Berlin'))
                    ->toTimeZone(new \DateTimeZone('Europe/Berlin')),
            ],
        ];
    }
}
