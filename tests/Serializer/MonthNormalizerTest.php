<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Serializer;

use DigitalCraftsman\DateTimeUtils\ValueObject\Month;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimeUtils\Serializer\MonthNormalizer */
final class MonthNormalizerTest extends TestCase
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
        $month = Month::fromString('2022-09');

        $normalizer = new MonthNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($month);
        $denormalizedData = $normalizer->denormalize($normalizedData, Month::class);

        // -- Assert
        self::assertEquals($month, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::denormalize
     */
    public function time_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new MonthNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Month::class);

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
        $month = Month::fromString('2022-09');

        $normalizer = new MonthNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($month));
    }

    /**
     * @test
     *
     * @covers ::supportsDenormalization
     */
    public function supports_denormalization(): void
    {
        // -- Arrange
        $normalizer = new MonthNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Month::class));
    }
}
