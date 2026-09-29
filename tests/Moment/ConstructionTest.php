<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Moment;

use DigitalCraftsman\DateTimePrecision\Moment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Moment::class)]
final class ConstructionTest extends TestCase
{
    #[Test]
    public function construction_with_date_time_works(): void
    {
        // -- Arrange
        $dateTimeImmutable = new \DateTimeImmutable('now');

        // -- Act
        $dateTime = Moment::fromDateTime($dateTimeImmutable);

        // -- Assert
        self::assertEquals($dateTimeImmutable, $dateTime->dateTime);
    }

    #[Test]
    #[DataProvider('dataProviderForUtc')]
    public function construction_converts_to_utc(
        string $expectedResult,
        \DateTimeImmutable $dateTimeImmutable,
    ): void {
        // -- Act
        $moment = new Moment($dateTimeImmutable);

        // -- Assert
        self::assertSame('UTC', $moment->dateTime->getTimezone()->getName());
        self::assertSame($expectedResult, $moment->normalize());
        self::assertEquals($dateTimeImmutable, $moment->dateTime);
    }

    /**
     * @return array<string, array{
     *   0: string,
     *   1: \DateTimeImmutable,
     * }>
     */
    public static function dataProviderForUtc(): array
    {
        return [
            'UTC' => [
                '2022-10-08T15:00:00.000000+00:00',
                new \DateTimeImmutable('2022-10-08 15:00:00', new \DateTimeZone('UTC')),
            ],
            'other time zone' => [
                '2022-10-08T13:00:00.000000+00:00',
                new \DateTimeImmutable('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin')),
            ],
            'offset' => [
                '2022-10-08T13:00:00.123456+00:00',
                new \DateTimeImmutable('2022-10-08T15:00:00.123456+02:00'),
            ],
            'zero offset' => [
                '2022-10-08T15:00:00.000000+00:00',
                new \DateTimeImmutable('2022-10-08T15:00:00+00:00'),
            ],
            'abbreviation Z' => [
                '2022-10-08T15:00:00.000000+00:00',
                new \DateTimeImmutable('2022-10-08T15:00:00Z'),
            ],
            'abbreviation of other time zone' => [
                '2022-10-08T13:00:00.000000+00:00',
                new \DateTimeImmutable('2022-10-08 15:00:00 CEST'),
            ],
        ];
    }

    #[Test]
    public function denormalization_with_offset_converts_to_utc(): void
    {
        // -- Act
        $moment = Moment::denormalize('2022-10-08T15:00:00.000000+02:00');

        // -- Assert
        self::assertSame('UTC', $moment->dateTime->getTimezone()->getName());
        self::assertSame('2022-10-08T13:00:00.000000+00:00', $moment->normalize());
    }

    #[Test]
    public function from_string_works(): void
    {
        // -- Arrange & Act
        $dateTime = Moment::fromString('2022-10-08 15:00:00');

        // -- Assert
        self::assertEquals(new \DateTimeImmutable('2022-10-08 15:00:00'), $dateTime->dateTime);
    }

    #[Test]
    public function from_string_in_time_zone_works(): void
    {
        // -- Arrange & Act
        $dateTime = Moment::fromStringInTimeZone('2022-10-08 15:00:00', new \DateTimeZone('Europe/Berlin'));

        // -- Assert
        self::assertEquals(new \DateTimeImmutable('2022-10-08 13:00:00'), $dateTime->dateTime);
    }
}
