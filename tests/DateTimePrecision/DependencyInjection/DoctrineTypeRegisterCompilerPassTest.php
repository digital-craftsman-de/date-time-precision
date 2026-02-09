<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTimePrecision\DependencyInjection;

use DigitalCraftsman\DateTimePrecision\Date;
use DigitalCraftsman\DateTimePrecision\DependencyInjection\DoctrineTypeRegisterCompilerPass;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\ArrayNormalizableThroughLookupType;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\IntNormalizableThroughLookupType;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableThroughLookupType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @coversDefaultClass \DigitalCraftsman\DateTimePrecision\DependencyInjection\DoctrineTypeRegisterCompilerPass
 */
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
        self::assertArrayHasKey(Moment::class, $updatedParameters);
        self::assertSame(['class' => StringNormalizableThroughLookupType::class], $updatedParameters[Moment::class]);

        self::assertArrayHasKey(Time::class, $updatedParameters);
        self::assertSame(['class' => StringNormalizableThroughLookupType::class], $updatedParameters[Time::class]);

        self::assertArrayHasKey(Weekday::class, $updatedParameters);
        self::assertSame(['class' => StringNormalizableThroughLookupType::class], $updatedParameters[Weekday::class]);

        self::assertArrayHasKey(Weekdays::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Weekdays::class]);

        self::assertArrayHasKey(Date::class, $updatedParameters);
        self::assertSame(['class' => StringNormalizableThroughLookupType::class], $updatedParameters[Date::class]);

        self::assertArrayHasKey(Month::class, $updatedParameters);
        self::assertSame(['class' => StringNormalizableThroughLookupType::class], $updatedParameters[Month::class]);

        self::assertArrayHasKey(Year::class, $updatedParameters);
        self::assertSame(['class' => IntNormalizableThroughLookupType::class], $updatedParameters[Year::class]);
    }
}
