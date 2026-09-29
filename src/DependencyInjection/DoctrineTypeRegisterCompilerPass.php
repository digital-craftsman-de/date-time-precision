<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DependencyInjection;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarPeriods;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\CalendarUnits;
use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\DateRanges;
use DigitalCraftsman\DateTimePrecision\Dates;
use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\MomentRanges;
use DigitalCraftsman\DateTimePrecision\Moments;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use DigitalCraftsman\DateTimePrecision\Recurrence;
use DigitalCraftsman\DateTimePrecision\RecurrenceFrequency;
use DigitalCraftsman\DateTimePrecision\Recurrences;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use DigitalCraftsman\DateTimePrecision\TimeRanges;
use DigitalCraftsman\DateTimePrecision\Times;
use DigitalCraftsman\DateTimePrecision\Week;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use DigitalCraftsman\DateTimePrecision\Weeks;
use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\ArrayNormalizableThroughLookupType;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\IntNormalizableThroughLookupType;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableThroughLookupType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final readonly class DoctrineTypeRegisterCompilerPass implements CompilerPassInterface
{
    public const string TYPE_DEFINITION_PARAMETER = 'doctrine.dbal.connection_factory.types';

    #[\Override]
    public function process(ContainerBuilder $container): void
    {
        /**
         * @var array<string, array{
         *     class: class-string,
         * }> $typeDefinitions
         */
        $typeDefinitions = $container->getParameter(self::TYPE_DEFINITION_PARAMETER);

        $typeDefinitions[Moment::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Time::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Weekday::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Weekdays::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Date::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Month::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Year::class] = ['class' => IntNormalizableThroughLookupType::class];
        $typeDefinitions[Day::class] = ['class' => IntNormalizableThroughLookupType::class];
        $typeDefinitions[Days::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Duration::class] = ['class' => IntNormalizableThroughLookupType::class];
        $typeDefinitions[CalendarUnit::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[CalendarPeriod::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[DateRange::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[MomentRange::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[TimeRange::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Moments::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Dates::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Times::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Months::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Years::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Durations::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[CalendarUnits::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[CalendarPeriods::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[DateRanges::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[MomentRanges::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[TimeRanges::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Week::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Weeks::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[RecurrenceFrequency::class] = ['class' => StringNormalizableThroughLookupType::class];
        $typeDefinitions[Recurrence::class] = ['class' => ArrayNormalizableThroughLookupType::class];
        $typeDefinitions[Recurrences::class] = ['class' => ArrayNormalizableThroughLookupType::class];

        $container->setParameter(self::TYPE_DEFINITION_PARAMETER, $typeDefinitions);
    }
}
