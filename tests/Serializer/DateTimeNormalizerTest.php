<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Serializer;

use DigitalCraftsman\DateTimeParts\ValueObject\DateTime;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeParts\Serializer\DateTimeNormalizer */
final class DateTimeNormalizerTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function date_time_normalization_and_denormalization_works(): void
    {
        // -- Arrange
        $dateTime = DateTime::fromString('2022-10-03 15:34:34');

        $normalizer = new DateTimeNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($dateTime);
        $denormalizedData = $normalizer->denormalize($normalizedData, DateTime::class);

        // -- Assert
        self::assertEquals($dateTime, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::normalize
     */
    public function date_time_normalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new DateTimeNormalizer();

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
    public function date_time_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new DateTimeNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, DateTime::class);

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
        $dateTime = DateTime::fromString('2022-10-03 15:34:34');

        $normalizer = new DateTimeNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($dateTime));
    }

    /**
     * @test
     *
     * @covers ::supportsDenormalization
     */
    public function supports_denormalization(): void
    {
        // -- Arrange
        $normalizer = new DateTimeNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, DateTime::class));
    }
}
