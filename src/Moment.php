<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizable;

final readonly class Moment implements \Stringable, StringNormalizable
{
    private const string ATOM_INCLUDING_MICROSECONDS = 'Y-m-d\TH:i:s.uP';

    // -- Construction

    public function __construct(
        public \DateTimeImmutable $dateTime,
    ) {
    }

    public static function fromString(string $string): self
    {
        return new self(new \DateTimeImmutable($string, new \DateTimeZone('UTC')));
    }

    public static function fromStringInTimeZone(
        string $string,
        \DateTimeZone $timeZone,
    ): self {
        $defaultTimeZone = new \DateTimeZone('UTC');

        return (new self(new \DateTimeImmutable($string, $timeZone)))
            ->toTimeZone($defaultTimeZone);
    }

    public static function fromDateTime(\DateTimeImmutable $dateTime): self
    {
        return new self($dateTime);
    }

    // Stringable

    #[\Override]
    public function __toString(): string
    {
        return $this->format(self::ATOM_INCLUDING_MICROSECONDS);
    }

    // -- String normalizable

    #[\Override]
    public static function denormalize(string $data): self
    {
        return new self(new \DateTimeImmutable($data, new \DateTimeZone('UTC')));
    }

    #[\Override]
    public function normalize(): string
    {
        return $this->format(self::ATOM_INCLUDING_MICROSECONDS);
    }

    // -- Accessors

    public function date(): Date
    {
        return Date::fromDateTime($this->dateTime);
    }

    public function dateInTimeZone(\DateTimeZone $timeZone): Date
    {
        return $this
            ->toTimeZone($timeZone)
            ->date();
    }

    public function time(): Time
    {
        return Time::fromDateTime($this->dateTime);
    }

    public function timeInTimeZone(\DateTimeZone $timeZone): Time
    {
        return $this
            ->toTimeZone($timeZone)
            ->time();
    }

    public function weekday(): Weekday
    {
        return Weekday::fromDateTime($this->dateTime);
    }

    public function weekdayInTimeZone(\DateTimeZone $timeZone): Weekday
    {
        return $this
            ->toTimeZone($timeZone)
            ->weekday();
    }

    public function month(): Month
    {
        return Month::fromDateTime($this->dateTime);
    }

    public function monthInTimeZone(\DateTimeZone $timeZone): Month
    {
        return $this
            ->toTimeZone($timeZone)
            ->month();
    }

    public function year(): Year
    {
        return Year::fromDateTime($this->dateTime);
    }

    public function yearInTimeZone(\DateTimeZone $timeZone): Year
    {
        return $this
            ->toTimeZone($timeZone)
            ->year();
    }

    public function isEqualTo(self $moment): bool
    {
        return $this->dateTime == $moment->dateTime;
    }

    public function isEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isEqualTo($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isEqualTo($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isEqualTo($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isEqualTo($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isEqualTo($comparator),
        };
    }

    public function isNotEqualTo(self $moment): bool
    {
        return $this->dateTime != $moment->dateTime;
    }

    public function isNotEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isNotEqualTo($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isNotEqualTo($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isNotEqualTo($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isNotEqualTo($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isNotEqualTo($comparator),
        };
    }

    public function isAfter(self $moment): bool
    {
        return $this->dateTime > $moment->dateTime;
    }

    public function isAfterInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isAfter($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isAfter($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isAfter($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isAfter($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isAfter($comparator),
        };
    }

    public function isNotAfter(self $moment): bool
    {
        return !($this->dateTime > $moment->dateTime);
    }

    public function isNotAfterInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isNotAfter($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isNotAfter($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isNotAfter($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isNotAfter($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isNotAfter($comparator),
        };
    }

    public function isAfterOrEqualTo(self $moment): bool
    {
        return $this->dateTime >= $moment->dateTime;
    }

    public function isAfterOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isAfterOrEqualTo($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isAfterOrEqualTo($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isAfterOrEqualTo($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isAfterOrEqualTo($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isAfterOrEqualTo($comparator),
        };
    }

    public function isNotAfterOrEqualTo(self $moment): bool
    {
        return !($this->dateTime >= $moment->dateTime);
    }

    public function isNotAfterOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isNotAfterOrEqualTo($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isNotAfterOrEqualTo($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isNotAfterOrEqualTo($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isNotAfterOrEqualTo($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isNotAfterOrEqualTo($comparator),
        };
    }

    public function isBeforeOrEqualTo(self $moment): bool
    {
        return $this->dateTime <= $moment->dateTime;
    }

    public function isBeforeOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isBeforeOrEqualTo($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isBeforeOrEqualTo($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isBeforeOrEqualTo($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isBeforeOrEqualTo($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isBeforeOrEqualTo($comparator),
        };
    }

    public function isNotBeforeOrEqualTo(self $moment): bool
    {
        return !($this->dateTime <= $moment->dateTime);
    }

    public function isNotBeforeOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isNotBeforeOrEqualTo($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isNotBeforeOrEqualTo($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isNotBeforeOrEqualTo($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isNotBeforeOrEqualTo($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isNotBeforeOrEqualTo($comparator),
        };
    }

    public function isBefore(
        self $before,
    ): bool {
        return $this->dateTime < $before->dateTime;
    }

    public function isBeforeInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isBefore($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isBefore($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isBefore($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isBefore($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isBefore($comparator),
        };
    }

    public function isNotBefore(self $moment): bool
    {
        return !($this->dateTime < $moment->dateTime);
    }

    public function isNotBeforeInTimeZone(
        Time | Weekday | Date | Month | Year $comparator,
        \DateTimeZone $timeZone,
    ): bool {
        return match (true) {
            $comparator instanceof Time => $this->timeInTimeZone($timeZone)->isNotBefore($comparator),
            $comparator instanceof Weekday => $this->weekdayInTimeZone($timeZone)->isNotBefore($comparator),
            $comparator instanceof Date => $this->dateInTimeZone($timeZone)->isNotBefore($comparator),
            $comparator instanceof Month => $this->monthInTimeZone($timeZone)->isNotBefore($comparator),
            $comparator instanceof Year => $this->yearInTimeZone($timeZone)->isNotBefore($comparator),
        };
    }

    public function compareTo(self $moment): int
    {
        return $this->dateTime <=> $moment->dateTime;
    }

    public function isAtMidnight(): bool
    {
        return $this
            ->time()
            ->isMidnight();
    }

    public function isNotAtMidnight(): bool
    {
        return $this
            ->time()
            ->isNotMidnight();
    }

    public function isAtMidnightInTimeZone(\DateTimeZone $timeZone): bool
    {
        return $this
            ->timeInTimeZone($timeZone)
            ->isMidnight();
    }

    public function isNotAtMidnightInTimeZone(\DateTimeZone $timeZone): bool
    {
        return $this
            ->timeInTimeZone($timeZone)
            ->isNotMidnight();
    }

    // -- Modifications

    public function modify(string $modifier): self
    {
        /** @psalm-suppress PossiblyFalseArgument */
        return new self(
            $this->dateTime->modify($modifier),
        );
    }

    public function format(string $format): string
    {
        return $this->dateTime->format($format);
    }

    public function formatInTimeZone(string $format, \DateTimeZone $timeZone): string
    {
        return $this
            ->toTimeZone($timeZone)
            ->dateTime
            ->format($format);
    }

    public function toTimeZone(\DateTimeZone $timeZone): self
    {
        return new self(
            $this->dateTime->setTimezone($timeZone),
        );
    }

    public function modifyInTimeZone(string $modifier, \DateTimeZone $timeZone): self
    {
        $originalTimeZone = $this->dateTime->getTimezone();

        /** @psalm-suppress PossiblyFalseReference */
        return new self(
            $this->dateTime
                ->setTimezone($timeZone)
                ->modify($modifier)
                ->setTimezone($originalTimeZone),
        );
    }

    public function setTime(Time $time): self
    {
        return new self(
            $this->dateTime->setTime(
                $time->hour,
                $time->minute,
                $time->second,
                $time->microsecond,
            ),
        );
    }

    public function setTimeInTimeZone(Time $time, \DateTimeZone $timeZone): self
    {
        $originalTimeZone = $this->dateTime->getTimezone();

        return $this
            ->toTimeZone($timeZone)
            ->setTime($time)
            ->toTimeZone($originalTimeZone);
    }

    public function midnight(): self
    {
        return $this->setTime(new Time(
            0,
            0,
            0,
        ));
    }

    public function midnightInTimeZone(\DateTimeZone $timeZone): self
    {
        $originalTimeZone = $this->dateTime->getTimezone();

        return $this
            ->toTimeZone($timeZone)
            ->midnight()
            ->toTimeZone($originalTimeZone);
    }

    // -- Guards

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotEqualTo
     */
    public function mustBeEqualTo(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotEqualTo($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotEqualTo
     */
    public function mustBeEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotEqualToInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsEqualTo
     */
    public function mustNotBeEqualTo(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isEqualTo($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsEqualTo
     */
    public function mustNotBeEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isEqualToInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotAfter
     */
    public function mustBeAfter(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfter($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotAfter
     */
    public function mustBeAfterInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfterInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsAfter
     */
    public function mustNotBeAfter(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfter($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsAfter
     */
    public function mustNotBeAfterInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfterInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsAfter();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotAfterOrEqualTo
     */
    public function mustBeAfterOrEqualTo(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfterOrEqualTo($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotAfterOrEqualTo
     */
    public function mustBeAfterOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotAfterOrEqualToInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsAfterOrEqualTo
     */
    public function mustNotBeAfterOrEqualTo(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfterOrEqualTo($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsAfterOrEqualTo
     */
    public function mustNotBeAfterOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isAfterOrEqualToInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsAfterOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotBefore
     */
    public function mustBeBefore(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBefore($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotBefore
     */
    public function mustBeBeforeInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBeforeInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsBefore
     */
    public function mustNotBeBefore(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBefore($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsBefore
     */
    public function mustNotBeBeforeInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBeforeInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsBefore();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotBeforeOrEqualTo
     */
    public function mustBeBeforeOrEqualTo(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBeforeOrEqualTo($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotBeforeOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsNotBeforeOrEqualTo
     */
    public function mustBeBeforeOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isNotBeforeOrEqualToInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsNotBeforeOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsBeforeOrEqualTo
     */
    public function mustNotBeBeforeOrEqualTo(
        self $moment,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBeforeOrEqualTo($moment)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsBeforeOrEqualTo();
        }
    }

    /**
     * @param ?callable(): \Throwable $otherwiseThrow
     *
     * @throws \Throwable
     * @throws Exception\MomentIsBeforeOrEqualTo
     */
    public function mustNotBeBeforeOrEqualToInTimeZone(
        Time | Weekday | Date | Month | Year $moment,
        \DateTimeZone $timeZone,
        ?callable $otherwiseThrow = null,
    ): void {
        if ($this->isBeforeOrEqualToInTimeZone($moment, $timeZone)) {
            throw $otherwiseThrow !== null
                ? $otherwiseThrow()
                : new Exception\MomentIsBeforeOrEqualTo();
        }
    }
}
