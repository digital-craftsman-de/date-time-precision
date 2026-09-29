<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Recurrence;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Exception\DateIsNotAnOccurrence;
use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomDateIsNotAnOccurrence;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Recurrence::class)]
#[CoversClass(DateIsNotAnOccurrence::class)]
final class MustOccurOnTest extends TestCase
{
    /**
     * @param ?class-string<\Throwable> $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function must_occur_on_works(
        ?string $expectedResult,
        string $date,
        ?callable $otherwiseThrow,
    ): void {
        // -- Arrange
        $recurrence = Recurrence::weekly(new Weekdays([Weekday::MONDAY]));

        // -- Act & Assert
        if ($expectedResult !== null) {
            $this->expectException($expectedResult);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $recurrence->mustOccurOn(Date::fromString($date), $otherwiseThrow);
    }

    /**
     * @return array<string, array{
     *   0: ?string,
     *   1: string,
     *   2: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'occurs' => [null, '2026-03-02', null],
            'default exception' => [DateIsNotAnOccurrence::class, '2026-03-03', null],
            'custom exception' => [CustomDateIsNotAnOccurrence::class, '2026-03-03', static fn () => new CustomDateIsNotAnOccurrence()],
        ];
    }
}
