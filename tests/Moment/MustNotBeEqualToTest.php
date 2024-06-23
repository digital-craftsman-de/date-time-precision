<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Exception\MomentIsEqualTo;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Test\Exception\CustomMomentIsEqualTo;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Moment */
final class MustNotBeEqualToTest extends TestCase
{
    /**
     * @test
     *
     * @param ?class-string<\Throwable> $expectedResult
     *
     * @dataProvider dataProvider
     *
     * @covers ::mustNotBeEqualTo
     */
    public function must_not_be_equal_to_works(
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

        $moment->mustNotBeEqualTo(
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
                MomentIsEqualTo::class,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                null,
            ],
            'custom exception' => [
                CustomMomentIsEqualTo::class,
                Moment::fromString('2022-10-08 15:00:00'),
                Moment::fromString('2022-10-08 15:00:00'),
                static fn () => new CustomMomentIsEqualTo(),
            ],
        ];
    }
}
