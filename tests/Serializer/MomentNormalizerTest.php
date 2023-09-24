<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Time;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Serializer\MomentNormalizer */
final class MomentNormalizerTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function moment_normalization_and_denormalization_works(): void
    {
        // -- Arrange
        $dateTime = Moment::fromString('2022-10-03 15:34:34');

        $normalizer = new MomentNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($dateTime);
        $denormalizedData = $normalizer->denormalize($normalizedData, Moment::class);

        // -- Assert
        self::assertEquals($dateTime, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::normalize
     */
    public function moment_normalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new MomentNormalizer();

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
    public function moment_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new MomentNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Moment::class);

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
        $dateTime = Moment::fromString('2022-10-03 15:34:34');

        $normalizer = new MomentNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($dateTime));
    }

    /**
     * @test
     *
     * @covers ::supportsNormalization
     */
    public function supports_normalization_fails(): void
    {
        // -- Arrange
        $time = Time::fromString('15:34:34');

        $normalizer = new MomentNormalizer();

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
        $normalizer = new MomentNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Moment::class));
    }
}
