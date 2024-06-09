<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DependencyInjection;

use DigitalCraftsman\DateTimePrecision\Doctrine\DateType;
use DigitalCraftsman\DateTimePrecision\Doctrine\MomentType;
use DigitalCraftsman\DateTimePrecision\Doctrine\MonthType;
use DigitalCraftsman\DateTimePrecision\Doctrine\TimeType;
use DigitalCraftsman\DateTimePrecision\Doctrine\WeekdaysType;
use DigitalCraftsman\DateTimePrecision\Doctrine\WeekdayType;
use DigitalCraftsman\DateTimePrecision\Doctrine\YearType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final readonly class DoctrineTypeRegisterCompilerPass implements CompilerPassInterface
{
    public const TYPE_DEFINITION_PARAMETER = 'doctrine.dbal.connection_factory.types';

    public function process(ContainerBuilder $container): void
    {
        /** @var array<string, array{class: class-string}> $typeDefinitions */
        $typeDefinitions = $container->getParameter(self::TYPE_DEFINITION_PARAMETER);

        $typeDefinitions['dtp_moment'] = ['class' => MomentType::class];
        $typeDefinitions['dtp_time'] = ['class' => TimeType::class];
        $typeDefinitions['dtp_weekday'] = ['class' => WeekdayType::class];
        $typeDefinitions['dtp_weekdays'] = ['class' => WeekdaysType::class];
        $typeDefinitions['dtp_date'] = ['class' => DateType::class];
        $typeDefinitions['dtp_month'] = ['class' => MonthType::class];
        $typeDefinitions['dtp_year'] = ['class' => YearType::class];

        $container->setParameter(self::TYPE_DEFINITION_PARAMETER, $typeDefinitions);
    }
}
