<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Serializer;

use DigitalCraftsman\DateTimeUtils\ValueObject\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeUtils\Serializer\TimeNormalizer */
final class TimeNormalizerTest extends TestCase
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
        $time = new Time(14, 50, 10, 234232);

        $normalizer = new TimeNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($time);
        $denormalizedData = $normalizer->denormalize($normalizedData, Time::class);

        // -- Assert
        self::assertEquals($time, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::denormalize
     */
    public function time_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new TimeNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Time::class);

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
        $time = new Time(14, 50, 10);

        $normalizer = new TimeNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($time));
    }

    /**
     * @test
     *
     * @covers ::supportsDenormalization
     */
    public function supports_denormalization(): void
    {
        // -- Arrange
        $normalizer = new TimeNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Time::class));
    }
}
