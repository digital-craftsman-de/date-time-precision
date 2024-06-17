<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Exception\MomentIsBeforeOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomMomentIsBeforeOrEqualTo;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class MustNotBeBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeBeforeOrEqualTo
     */
    public function must_not_be_before_or_equal_to_works(
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

        $moment->mustNotBeBeforeOrEqualTo(
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
                MomentIsBeforeOrEqualTo::class,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 16:00:00'),
                null,
            ],
            'custom exception' => [
                CustomMomentIsBeforeOrEqualTo::class,
                Moment::fromString('2022-10-08 16:00:00'),
                Moment::fromString('2022-10-08 17:00:00'),
                static fn () => new CustomMomentIsBeforeOrEqualTo(),
            ],
        ];
    }
}
