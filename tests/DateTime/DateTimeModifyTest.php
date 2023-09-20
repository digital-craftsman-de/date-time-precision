<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\DateTime;

use DigitalCraftsman\DateTimeParts\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\DateTime */
final class DateTimeModifyTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modify
     */
    public function modify_works(
        DateTime $expectedResult,
        DateTime $dateTime,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->modify($modifier)));
    }

    /**
     * @return array<string, array{
     *   0: DateTime,
     *   1: DateTime,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'subtract 15 minutes' => [
                DateTime::fromString('2022-10-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:15:00'),
                '- 15 minutes',
            ],
            'subtract one day' => [
                DateTime::fromString('2022-10-07 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
                '- 1 day',
            ],
            'add one month' => [
                DateTime::fromString('2022-11-08 15:00:00'),
                DateTime::fromString('2022-10-08 15:00:00'),
                '+ 1 month',
            ],
        ];
    }
}
