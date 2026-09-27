<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Doctrine\NormalizableTypeWithSQLDeclaration;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableStringDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableStringDenormalizableTrait;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;

final readonly class Moment implements \Stringable, StringNormalizable, NullableStringDenormalizable, NormalizableTypeWithSQLDeclaration
{
    use NullableStringDenormalizableTrait;

    private const string ATOM_INCLUDING_MICROSECONDS = 'Y-m-d\TH:i:s.uP';

    // -- Construction

    /**
     * Always in UTC. The moment in time of the given date time is kept, but it's converted to UTC when it's in another timezone or only
     * has an offset or abbreviation (like "+02:00" or "Z").
     */
    public \DateTimeImmutable $dateTime;

    public function __construct(
        \DateTimeImmutable $dateTime,
    ) {
        $this->dateTime = $dateTime->setTimezone(new \DateTimeZone('UTC'));
    }

    public static function fromString(string $string): self
    {
        return new self(new \DateTimeImmutable($string, new \DateTimeZone('UTC')));
    }

    public static function fromStringInTimeZone(
        string $string,
        \DateTimeZone $timeZone,
    ): self {
        return new self(new \DateTimeImmutable($string, $timeZone));
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
        return Date::fromDateTime($this->dateTime->setTimezone($timeZone));
    }

    public function time(): Time
    {
        return Time::fromDateTime($this->dateTime);
    }

    public function timeInTimeZone(\DateTimeZone $timeZone): Time
    {
        return Time::fromDateTime($this->dateTime->setTimezone($timeZone));
    }

    public function weekday(): Weekday
    {
        return Weekday::fromDateTime($this->dateTime);
    }

    public function weekdayInTimeZone(\DateTimeZone $timeZone): Weekday
    {
        return Weekday::fromDateTime($this->dateTime->setTimezone($timeZone));
    }

    public function month(): Month
    {
        return Month::fromDateTime($this->dateTime);
    }

    public function monthInTimeZone(\DateTimeZone $timeZone): Month
    {
        return Month::fromDateTime($this->dateTime->setTimezone($timeZone));
    }

    public function year(): Year
    {
        return Year::fromDateTime($this->dateTime);
    }

    public function yearInTimeZone(\DateTimeZone $timeZone): Year
    {
        return Year::fromDateTime($this->dateTime->setTimezone($timeZone));
    }

    public function day(): Day
    {
        return Day::fromDateTime($this->dateTime);
    }

    public function dayInTimeZone(\DateTimeZone $timeZone): Day
    {
        return Day::fromDateTime($this->dateTime->setTimezone($timeZone));
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

    /**
     * Exact elapsed time on the timeline, independent of any timezone.
     *
     * @throws Exception\MomentIsBefore when the given moment is before this moment
     */
    public function durationUntil(self $moment): Duration
    {
        $moment->mustNotBeBefore($this);

        return Duration::between($this->dateTime, $moment->dateTime);
    }

    /**
     * Only full units are counted in the calendar of the given timezone (e.g. 31.01. until 01.03. is 0 months and 29 days).
     *
     * @throws Exception\MomentIsBefore when the given moment is before this moment
     */
    public function periodUntilInTimeZone(
        self $moment,
        CalendarUnit $calendarUnit,
        \DateTimeZone $timeZone,
    ): CalendarPeriod {
        $moment->mustNotBeBefore($this);

        return CalendarPeriod::fromDateInterval(
            $this->dateTime
                ->setTimezone($timeZone)
                ->diff($moment->dateTime->setTimezone($timeZone)),
            $calendarUnit,
        );
    }

    // -- Modifications

    /**
     * The modification is applied in UTC. Use modifyInTimeZone for modifications in the calendar of a specific timezone.
     */
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
        return $this->dateTime
            ->setTimezone($timeZone)
            ->format($format);
    }

    /**
     * @deprecated A moment is always in UTC, therefore this method has no effect anymore. Use the *InTimeZone methods instead.
     */
    public function toTimeZone(\DateTimeZone $timeZone): self
    {
        return new self(
            $this->dateTime->setTimezone($timeZone),
        );
    }

    /**
     * Modifications with hours, minutes or seconds are applied to the wall clock of the timezone. Across a change of daylight saving
     * time, the elapsed time therefore differs from the modifier (e.g. "+2 hours" might only be 1 or up to 3 hours). Use add with a
     * Duration for elapsed time.
     */
    public function modifyInTimeZone(string $modifier, \DateTimeZone $timeZone): self
    {
        /** @psalm-suppress PossiblyFalseArgument */
        return new self(
            $this->dateTime
                ->setTimezone($timeZone)
                ->modify($modifier),
        );
    }

    /**
     * Adds exact elapsed time on the timeline, independent of any timezone.
     */
    public function add(Duration $duration): self
    {
        return $this->modify(sprintf('+%d microseconds', $duration->microseconds));
    }

    /**
     * Subtracts exact elapsed time on the timeline, independent of any timezone.
     */
    public function subtract(Duration $duration): self
    {
        return $this->modify(sprintf('-%d microseconds', $duration->microseconds));
    }

    /**
     * Moves in the calendar of the given timezone and follows the native overflow behaviour of \DateTimeImmutable (e.g. 31.01. + 1 month =
     * 03.03.). When the resulting local time doesn't exist (because of daylight saving time), it's moved forward like natively.
     */
    public function addInTimeZone(CalendarPeriod $calendarPeriod, \DateTimeZone $timeZone): self
    {
        return $this->modifyInTimeZone(sprintf('+%s', $calendarPeriod->modifier()), $timeZone);
    }

    /**
     * Moves in the calendar of the given timezone and follows the native overflow behaviour of \DateTimeImmutable (e.g. 31.03. - 1 month =
     * 03.03.). When the resulting local time doesn't exist (because of daylight saving time), it's moved forward like natively.
     */
    public function subtractInTimeZone(CalendarPeriod $calendarPeriod, \DateTimeZone $timeZone): self
    {
        return $this->modifyInTimeZone(sprintf('-%s', $calendarPeriod->modifier()), $timeZone);
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
        return new self(
            $this->dateTime
                ->setTimezone($timeZone)
                ->setTime(
                    $time->hour,
                    $time->minute,
                    $time->second,
                    $time->microsecond,
                ),
        );
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
        return $this->setTimeInTimeZone(
            new Time(
                0,
                0,
                0,
            ),
            $timeZone,
        );
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

    /**
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof PostgreSQLPlatform) {
            return 'TIMESTAMP(6) WITHOUT TIME ZONE';
        }

        if ($platform instanceof MySQLPlatform) {
            return 'DATETIME(6)';
        }

        throw new \RuntimeException('Unsupported platform');
    }
}
