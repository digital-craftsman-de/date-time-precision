<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Year;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\Serializer\YearNormalizer */
final class YearNormalizerTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::normalize
     * @covers ::denormalize
     */
    public function year_normalization_and_denormalization_works(): void
    {
        // -- Arrange
        $year = new Year(2022);

        $normalizer = new YearNormalizer();

        // -- Act
        $normalizedData = $normalizer->normalize($year);
        $denormalizedData = $normalizer->denormalize($normalizedData, Year::class);

        // -- Assert
        self::assertEquals($year, $denormalizedData);
    }

    /**
     * @test
     *
     * @covers ::normalize
     */
    public function year_normalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new YearNormalizer();

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
    public function year_denormalization_with_null_works(): void
    {
        // -- Arrange
        $normalizer = new YearNormalizer();

        // -- Act
        $denormalizedData = $normalizer->denormalize(null, Year::class);

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
        $year = new Year(2022);

        $normalizer = new YearNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsNormalization($year));
    }

    /**
     * @test
     *
     * @covers ::supportsNormalization
     */
    public function supports_normalization_fails(): void
    {
        // -- Arrange
        $month = Month::fromString('2022-08');

        $normalizer = new YearNormalizer();

        // -- Act & Assert
        self::assertFalse($normalizer->supportsNormalization($month));
    }

    /**
     * @test
     *
     * @covers ::supportsDenormalization
     */
    public function supports_denormalization(): void
    {
        // -- Arrange
        $normalizer = new YearNormalizer();

        // -- Act & Assert
        self::assertTrue($normalizer->supportsDenormalization(null, Year::class));
    }
}
