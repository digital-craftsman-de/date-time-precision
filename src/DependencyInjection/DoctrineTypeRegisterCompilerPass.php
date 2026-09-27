<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DependencyInjection;

use DigitalCraftsman\DateTimePrecision\CalendarPeriod;
use DigitalCraftsman\DateTimePrecision\CalendarUnit;
use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DateRange;
use DigitalCraftsman\DateTimePrecision\Day;
use DigitalCraftsman\DateTimePrecision\Days;
use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use DigitalCraftsman\DateTimePrecision\Year;
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

        $container->setParameter(self::TYPE_DEFINITION_PARAMETER, $typeDefinitions);
    }
}
