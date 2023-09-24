<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class ModifyTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @covers ::modify
     */
    public function modify_works(
        Moment $expectedResult,
        Moment $dateTime,
        string $modifier,
    ): void {
        // -- Act & Assert
        self::assertTrue($expectedResult->isEqualTo($dateTime->modify($modifier)));
    }

    /**
     * @return array<string, array{
     *   0: Moment,
     *   1: Moment,
     *   2: string,
     * }>
     */
    public function dataProvider(): array
    {
        return [
            'subtract 15 minutes' => [
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:15:00'),
                '- 15 minutes',
            ],
            'subtract one day' => [
                Moment::fromString('2022-10-07 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                '- 1 day',
            ],
            'add one month' => [
                Moment::fromString('2022-11-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                '+ 1 month',
            ],
        ];
    }
}
