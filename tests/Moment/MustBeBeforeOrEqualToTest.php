<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Exception\MomentIsNotBeforeOrEqualTo;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomMomentIsNotBeforeOrEqualTo;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class MustBeBeforeOrEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustBeBeforeOrEqualTo
     */
    public function must_be_before_or_equal_to_works(
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

        $moment->mustBeBeforeOrEqualTo(
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
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 16:00:00'),
                null,
            ],
            'default exception' => [
                MomentIsNotBeforeOrEqualTo::class,
                Moment::fromString('2022-10-08 16:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                null,
            ],
            'custom exception' => [
                CustomMomentIsNotBeforeOrEqualTo::class,
                Moment::fromString('2022-10-08 16:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                static fn () => new CustomMomentIsNotBeforeOrEqualTo(),
            ],
        ];
    }
}
