<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Serializer;

use DigitalCraftsman\DateTimeParts\Date;
use DigitalCraftsman\DateTimeParts\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Serializer\DateNormalizer */
final class DateNormalizerTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function time_normalization_and_denormalization_works(): void
    {
        // -- Arrange
        $date = Date::fromString('2022-09-04');

        $normalizer = new DateNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($date);
        $denormalizedData = $normalizer->denormalize($normalizedData, Date::class);

        // -- Assert
        self::assertEquals($date, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::normalize
     */
    public function time_normalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new DateNormalizer();

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
    public function time_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new DateNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Date::class);

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
        $date = Date::fromString('2022-09-04');

        $normalizer = new DateNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($date));
    }

    /**
     * @test
     *
     * @covers ::supportsNormalization
     */
    public function supports_normalization_fails(): void
    {
        // -- Arrange
        $time = Time::fromString('15:00:00');

        $normalizer = new DateNormalizer();

        // -- Act & Assert
        self::assertFalse($normalizer->supportsNormalization($time));
    }

    /**
     * @test
     *
     * @covers ::supportsDenormalization
     */
    public function supports_denormalization(): void
    {
        // -- Arrange
        $normalizer = new DateNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Date::class));
    }
}
