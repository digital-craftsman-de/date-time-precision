<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Exception\MomentIsNotAfter;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomMomentIsNotAfter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
#[CoversClass(MomentIsNotAfter::class)]
final class MustBeAfterTest extends TestCase
{
    /**
     * @param ?class-string<\Throwable> $expectedResult
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function must_be_after_works(
        ?string $expectedResult,
        Moment $moment,
        Moment $comparator,
        ?callable $otherwiseThrow,
    ): void {
        // -- Act & Assert
        if ($expectedResult !== null) {
            $this->expectException($expectedResult);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $moment->mustBeAfter(
            $comparator,
            $otherwiseThrow,
        );
    }

    /**
     * @return array<string, array{
     *   0: ?string,
     *   1: Moment,
     *   2: Moment,
     *   3: ?callable(): \Throwable
     * }>
     */
    public static function dataProvider(): array
    {
        return [
            'without exception' => [
                null,
                Moment::fromString('2022-10-08 16:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                null,
            ],
            'default exception' => [
                MomentIsNotAfter::class,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2023-10-08 15:00:00'),
                null,
            ],
            'custom exception' => [
                CustomMomentIsNotAfter::class,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                static fn () => new CustomMomentIsNotAfter(),
            ],
        ];
    }
}
