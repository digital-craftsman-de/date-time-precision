<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DependencyInjection;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Time;
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

        $container->setParameter(self::TYPE_DEFINITION_PARAMETER, $typeDefinitions);
    }
}
