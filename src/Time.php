<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Doctrine\NormalizableTypeWithSQLDeclaration;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizable;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final readonly class Time implements \Stringable, StringNormalizable, NormalizableTypeWithSQLDeclaration
{
    private const string TIME_FORMAT = 'H:i:s';
    private const int MINUTES_IN_AN_HOUR = 60;

    // -- Construction

    public function __construct(
        public int $hour,
        public int $minute,
        public int $second,
        public int $microsecond = 0,
    ) {
        if ($this->hour < 0
            || $this->hour > 23
        ) {
            throw new \InvalidArgumentException('Hour must be greater or equal 0 and less or equal than 23');
        }

        if ($this->minute < 0
            || $this->minute >= 60
        ) {
            throw new \InvalidArgumentException('Minute must be greater or equal 0 and less than 60');
        }

        if ($this->second < 0
            || $this->second >= 60
        ) {
            throw new \InvalidArgumentException('Second must be greater or equal 0 and less than 60');
        }

        if ($this->microsecond < 0
            || $this->microsecond >= 1000000
        ) {
            throw new \InvalidArgumentException('Microsecond must be greater or equal 0 and less than 1000000');
        }
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        /**
         * @psalm-suppress PossiblyNullArrayAccess
         * @psalm-suppress PossiblyUndefinedArrayOffset
         */
        [$hour, $minute, $second, $microsecond] = sscanf(
            $dateTime->format('H-i-s.u'),
            '%d-%d-%d.%d',
        );

        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress PossiblyInvalidArgument
         */
        return new self(
            $hour,
            $minute,
            $second,
            $microsecond,
        );
    }

    public static function fromString(string $time): self
    {
        try {
            return self::fromDateTime(new \DateTimeImmutable($time));
        } catch (\Exception) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is not valid time format.', $time));
        }
    }

    // -- Stringable

    #[\Override]
    public function __toString(): string
    {
        return $this->format(self::TIME_FORMAT);
    }

    // -- String normalizable

    #[\Override]
    public static function denormalize(string $data): self
    {
        return self::fromString($data);
    }

    #[\Override]
    public function normalize(): string
    {
        return $this->format(self::TIME_FORMAT);
    }

    // -- Accessors

    public function isAfter(self $time): bool
    {
        return $this->toDateTimeImmutable() > $time->toDateTimeImmutable();
    }

    public function isNotAfter(self $time): bool
    {
        return !($this->toDateTimeImmutable() > $time->toDateTimeImmutable());
    }

    public function isAfterOrEqualTo(self $time): bool
    {
        return $this->toDateTimeImmutable() >= $time->toDateTimeImmutable();
    }

    public function isNotAfterOrEqualTo(self $time): bool
    {
        return !($this->toDateTimeImmutable() >= $time->toDateTimeImmutable());
    }

    public function isEqualTo(self $time): bool
    {
        return $this->toDateTimeImmutable() == $time->toDateTimeImmutable();
    }

    public function isNotEqualTo(self $time): bool
    {
        return $this->toDateTimeImmutable() != $time->toDateTimeImmutable();
    }

    public function isBefore(self $time): bool
    {
        return $this->toDateTimeImmutable() < $time->toDateTimeImmutable();
    }

    public function isNotBefore(self $time): bool
    {
        return !($this->toDateTimeImmutable() < $time->toDateTimeImmutable());
    }

    public function isBeforeOrEqualTo(self $time): bool
    {
        return $this->toDateTimeImmutable() <= $time->toDateTimeImmutable();
    }

    public function isNotBeforeOrEqualTo(self $time): bool
    {
        return !($this->toDateTimeImmutable() <= $time->toDateTimeImmutable());
    }

    public function isMidnight(): bool
    {
        return $this->hour === 0
            && $this->minute === 0
            && $this->second === 0
            && $this->microsecond === 0;
    }

    public function isNotMidnight(): bool
    {
        return $this->hour !== 0
            || $this->minute !== 0
            || $this->second !== 0
            || $this->microsecond !== 0;
    }

    public function compareTo(self $time): int
    {
        return $this->toDateTimeImmutable() <=> $time->toDateTimeImmutable();
    }

    public function distanceInMinutesTo(self $time): int
    {
        $diff = $this->diff($time);

        return $diff->h * self::MINUTES_IN_AN_HOUR + $diff->i;
    }

    // -- Guards

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsNotEqualTo
     */
    public function mustBeEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsNotEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsEqualTo
     */
    public function mustNotBeEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsNotAfter
     */
    public function mustBeAfter(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfter($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsNotAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsAfter
     */
    public function mustNotBeAfter(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfter($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsNotAfterOrEqualTo
     */
    public function mustBeAfterOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfterOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsNotAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsAfterOrEqualTo
     */
    public function mustNotBeAfterOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfterOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsNotBefore
     */
    public function mustBeBefore(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBefore($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsNotBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsBefore
     */
    public function mustNotBeBefore(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBefore($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsNotBeforeOrEqualTo
     */
    public function mustBeBeforeOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBeforeOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsNotBeforeOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\TimeIsBeforeOrEqualTo
     */
    public function mustNotBeBeforeOrEqualTo(
        self $date,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBeforeOrEqualTo($date)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\TimeIsBeforeOrEqualTo();
        }
    }

    // -- Mutations

    public function format(string $format): string
    {
        return $this
            ->toDateTimeImmutable()
            ->format($format);
    }

    public function diff(self $time): \DateInterval
    {
        return $this
            ->toDateTimeImmutable()
            ->diff($time->toDateTimeImmutable());
    }

    public function modify(string $modifier): self
    {
        $modifiedDateTime = $this->toDateTimeImmutable()
            ->modify($modifier);

        /** @psalm-suppress PossiblyFalseArgument */
        return self::fromDateTime($modifiedDateTime);
    }

    private function toDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(
            sprintf(
                '2000-01-01 %d:%d:%d.%d',
                $this->hour,
                $this->minute,
                $this->second,
                $this->microsecond,
            ),
        );
    }

    /**
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getTimeTypeDeclarationSQL($column);
    }
}
