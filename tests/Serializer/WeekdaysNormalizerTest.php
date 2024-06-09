<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Serializer\WeekdaysNormalizer */
final class WeekdaysNormalizerTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function weekdays_normalization_and_denormalization_works(): void
    {
        // -- Arrange
        $weekdays = new Weekdays([
            Weekday::MONDAY,
            Weekday::SATURDAY,
        ]);

        $normalizer = new WeekdaysNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($weekdays);
        $denormalizedData = $normalizer->denormalize($normalizedData, Weekdays::class);

        // -- Assert
        self::assertEquals($weekdays, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::normalize
     */
    public function weekday_normalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new WeekdaysNormalizer();

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
    public function weekdays_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new WeekdaysNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Weekdays::class);

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
        $weekdays = new Weekdays([
            Weekday::MONDAY,
            Weekday::SATURDAY,
        ]);

        $normalizer = new WeekdaysNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($weekdays));
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

        $normalizer = new WeekdaysNormalizer();

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
        $normalizer = new WeekdaysNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Weekdays::class));
    }
}
