<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Serializer\WeekdayNormalizer */
final class WeekdayNormalizerTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function weekday_normalization_and_denormalization_works(): void
    {
        // -- Arrange
        $weekday = Weekday::MONDAY;

        $normalizer = new WeekdayNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($weekday);
        $denormalizedData = $normalizer->denormalize($normalizedData, Weekday::class);

        // -- Assert
        self::assertEquals($weekday, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::normalize
     */
    public function weekday_normalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new WeekdayNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize(null);

        // -- Assert
        self::assertNull($normalizedData);
    }

    /**
     * @test
     *
     * @covers ::denormalize
     */
    public function weekday_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new WeekdayNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Weekday::class);

        // -- Assert
        self::assertNull($denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::supportsNormalization
     */
    public function supports_normalization(): void
    {
        // -- Arrange
        $weekday = Weekday::TUESDAY;

        $normalizer = new WeekdayNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($weekday));
    }

    /**
     * @test
     *
     * @covers ::supportsNormalization
     */
    public function supports_normalization_fails(): void
    {
        // -- Arrange
        $year = Year::fromString('2022');

        $normalizer = new WeekdayNormalizer();

        // -- Act & Assert
        self::assertFalse($normalizer->supportsNormalization($year));
    }

    /**
     * @test
     *
     * @covers ::supportsDenormalization
     */
    public function supports_denormalization(): void
    {
        // -- Arrange
        $normalizer = new WeekdayNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Weekday::class));
    }
}
