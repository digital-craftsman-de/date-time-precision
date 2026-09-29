<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Year;

use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Year::class)]
final class MinMaxCompareTest extends TestCase
{
    #[Test]
    public function min_works(): void
    {
        // -- Act & Assert
        self::assertTrue(new Year(2019)->isEqualTo(Year::min(new Year(2023), new Year(2019), new Year(2027))));
        self::assertTrue(new Year(2019)->isEqualTo(Year::min(new Year(2019), new Year(2023))));
        self::assertTrue(new Year(2023)->isEqualTo(Year::min(new Year(2023))));
    }

    #[Test]
    public function max_works(): void
    {
        // -- Act & Assert
        self::assertTrue(new Year(2027)->isEqualTo(Year::max(new Year(2023), new Year(2027), new Year(2019))));
        self::assertTrue(new Year(2027)->isEqualTo(Year::max(new Year(2027), new Year(2023))));
        self::assertTrue(new Year(2023)->isEqualTo(Year::max(new Year(2023))));
    }

    #[Test]
    public function compare_works_for_sorting(): void
    {
        // -- Arrange
        $values = [new Year(2023), new Year(2027), new Year(2019)];

        // -- Act
        usort($values, Year::compare(...));

        // -- Assert
        self::assertEquals([new Year(2019), new Year(2023), new Year(2027)], $values);
        self::assertSame(0, Year::compare(new Year(2023), new Year(2023)));
    }
}
