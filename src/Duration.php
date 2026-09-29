<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Doctrine\NormalizableTypeWithSQLDeclaration;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\IntNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableIntDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableIntDenormalizableTrait;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Elapsed time on the timeline. It's independent of any timezone and therefore always exact (e.g. 2 hours are always 2 hours, even when
 * the clock is changed for daylight saving time in between). For a movement in the calendar (days, months, ...) use CalendarPeriod.
 */
final readonly class Duration implements IntNormalizable, NullableIntDenormalizable, NormalizableTypeWithSQLDeclaration
{
    use NullableIntDenormalizableTrait;

    private const int MICROSECONDS_IN_A_MILLISECOND = 1_000;
    private const int MICROSECONDS_IN_A_SECOND = 1_000_000;
    private const int MICROSECONDS_IN_A_MINUTE = 60_000_000;
    private const int MICROSECONDS_IN_AN_HOUR = 3_600_000_000;

    // -- Construction

    public function __construct(
        public int $microseconds,
    ) {
        if ($microseconds < 0) {
            throw new Exception\InvalidDuration($microseconds);
        }
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromMicroseconds(int $microseconds): self
    {
        return new self($microseconds);
    }

    public static function fromMilliseconds(int $milliseconds): self
    {
        return new self($milliseconds * self::MICROSECONDS_IN_A_MILLISECOND);
    }

    public static function fromSeconds(int $seconds): self
    {
        return new self($seconds * self::MICROSECONDS_IN_A_SECOND);
    }

    public static function fromMinutes(int $minutes): self
    {
        return new self($minutes * self::MICROSECONDS_IN_A_MINUTE);
    }

    public static function fromHours(int $hours): self
    {
        return new self($hours * self::MICROSECONDS_IN_AN_HOUR);
    }

    /**
     * @internal
     */
    public static function between(
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
    ): self {
        $seconds = $end->getTimestamp() - $start->getTimestamp();
        $microseconds = $end->getMicrosecond() - $start->getMicrosecond();

        return new self($seconds * self::MICROSECONDS_IN_A_SECOND + $microseconds);
    }

    // -- Int normalizable

    #[\Override]
    public static function denormalize(int $data): self
    {
        return new self($data);
    }

    #[\Override]
    public function normalize(): int
    {
        return $this->microseconds;
    }

    // -- Accessors

    public function inMicroseconds(): int
    {
        return $this->microseconds;
    }

    public function inMilliseconds(): int
    {
        return intdiv($this->microseconds, self::MICROSECONDS_IN_A_MILLISECOND);
    }

    public function inSeconds(): int
    {
        return intdiv($this->microseconds, self::MICROSECONDS_IN_A_SECOND);
    }

    public function inMinutes(): int
    {
        return intdiv($this->microseconds, self::MICROSECONDS_IN_A_MINUTE);
    }

    public function inHours(): int
    {
        return intdiv($this->microseconds, self::MICROSECONDS_IN_AN_HOUR);
    }

    public function isZero(): bool
    {
        return $this->microseconds === 0;
    }

    public function isNotZero(): bool
    {
        return $this->microseconds !== 0;
    }

    public function isEqualTo(self $duration): bool
    {
        return $this->microseconds === $duration->microseconds;
    }

    public function isNotEqualTo(self $duration): bool
    {
        return $this->microseconds !== $duration->microseconds;
    }

    public function isLongerThan(self $duration): bool
    {
        return $this->microseconds > $duration->microseconds;
    }

    public function isLongerThanOrEqualTo(self $duration): bool
    {
        return $this->microseconds >= $duration->microseconds;
    }

    public function isShorterThan(self $duration): bool
    {
        return $this->microseconds < $duration->microseconds;
    }

    public function isShorterThanOrEqualTo(self $duration): bool
    {
        return $this->microseconds <= $duration->microseconds;
    }

    public function compareTo(self $duration): int
    {
        return $this->microseconds <=> $duration->microseconds;
    }

    // -- Mutations

    public function add(self $duration): self
    {
        return new self($this->microseconds + $duration->microseconds);
    }

    /**
     * @throws Exception\InvalidDuration when the result would be negative
     */
    public function subtract(self $duration): self
    {
        return new self($this->microseconds - $duration->microseconds);
    }

    /**
     * @throws Exception\InvalidDuration when the factor is negative
     */
    public function multiply(int $factor): self
    {
        return new self($this->microseconds * $factor);
    }

    /**
     * Returns how often the given duration fits into this duration.
     *
     * @throws \DivisionByZeroError when the given duration is zero
     */
    public function divideBy(self $duration): float
    {
        return $this->microseconds / $duration->microseconds;
    }

    /**
     * Microseconds exceed the range of a regular integer column after roughly 35 minutes.
     *
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBigIntTypeDeclarationSQL($column);
    }
}
