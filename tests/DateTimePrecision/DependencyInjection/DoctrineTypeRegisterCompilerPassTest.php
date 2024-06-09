<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTimePrecision\DependencyInjection;

use DigitalCraftsman\DateTimePrecision\DependencyInjection\DoctrineTypeRegisterCompilerPass;
use DigitalCraftsman\DateTimePrecision\Doctrine\DateType;
use DigitalCraftsman\DateTimePrecision\Doctrine\MomentType;
use DigitalCraftsman\DateTimePrecision\Doctrine\MonthType;
use DigitalCraftsman\DateTimePrecision\Doctrine\TimeType;
use DigitalCraftsman\DateTimePrecision\Doctrine\WeekdayType;
use DigitalCraftsman\DateTimePrecision\Doctrine\YearType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/** @coversDefaultClass \DigitalCraftsman\DateTimePrecision\DependencyInjection\DoctrineTypeRegisterCompilerPass */
final class DoctrineTypeRegisterCompilerPassTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::process
     */
    public function process_works(): void
    {
        // -- Arrange
        $compilerPass = new DoctrineTypeRegisterCompilerPass();
        $container = new ContainerBuilder(new ParameterBag([
            DoctrineTypeRegisterCompilerPass::TYPE_DEFINITION_PARAMETER => [],
        ]));

        // -- Act
        $compilerPass->process($container);

        // -- Assert
        /** @var array $updatedParameters */
        $updatedParameters = $container->getParameter(DoctrineTypeRegisterCompilerPass::TYPE_DEFINITION_PARAMETER);
        self::assertArrayHasKey('dtp_moment', $updatedParameters);
        self::assertSame(['class' => MomentType::class], $updatedParameters['dtp_moment']);

        self::assertArrayHasKey('dtp_time', $updatedParameters);
        self::assertSame(['class' => TimeType::class], $updatedParameters['dtp_time']);

        self::assertArrayHasKey('dtp_weekday', $updatedParameters);
        self::assertSame(['class' => WeekdayType::class], $updatedParameters['dtp_weekday']);

        self::assertArrayHasKey('dtp_date', $updatedParameters);
        self::assertSame(['class' => DateType::class], $updatedParameters['dtp_date']);

        self::assertArrayHasKey('dtp_month', $updatedParameters);
        self::assertSame(['class' => MonthType::class], $updatedParameters['dtp_month']);

        self::assertArrayHasKey('dtp_year', $updatedParameters);
        self::assertSame(['class' => YearType::class], $updatedParameters['dtp_year']);
    }
}
