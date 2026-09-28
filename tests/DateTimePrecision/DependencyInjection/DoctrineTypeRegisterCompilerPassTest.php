<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTimePrecision\DependencyInjection;

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
use DigitalCraftsman\DateTimePrecision\DependencyInjection\DoctrineTypeRegisterCompilerPass;
use DigitalCraftsman\DateTimePrecision\Duration;
use DigitalCraftsman\DateTimePrecision\Durations;
use DigitalCraftsman\DateTimePrecision\Moment;
use DigitalCraftsman\DateTimePrecision\MomentRange;
use DigitalCraftsman\DateTimePrecision\MomentRanges;
use DigitalCraftsman\DateTimePrecision\Moments;
use DigitalCraftsman\DateTimePrecision\Month;
use DigitalCraftsman\DateTimePrecision\Months;
use DigitalCraftsman\DateTimePrecision\Time;
use DigitalCraftsman\DateTimePrecision\TimeRange;
use DigitalCraftsman\DateTimePrecision\TimeRanges;
use DigitalCraftsman\DateTimePrecision\Times;
use DigitalCraftsman\DateTimePrecision\Weekday;
use DigitalCraftsman\DateTimePrecision\Weekdays;
use DigitalCraftsman\DateTimePrecision\Year;
use DigitalCraftsman\DateTimePrecision\Years;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\ArrayNormalizableThroughLookupType;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\IntNormalizableThroughLookupType;
use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableThroughLookupType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

#[CoversClass(DoctrineTypeRegisterCompilerPass::class)]
final class DoctrineTypeRegisterCompilerPassTest extends TestCase
{
    #[Test]
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

        self::assertArrayHasKey(Day::class, $updatedParameters);
        self::assertSame(['class' => IntNormalizableThroughLookupType::class], $updatedParameters[Day::class]);

        self::assertArrayHasKey(Days::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Days::class]);

        self::assertArrayHasKey(Duration::class, $updatedParameters);
        self::assertSame(['class' => IntNormalizableThroughLookupType::class], $updatedParameters[Duration::class]);

        self::assertArrayHasKey(CalendarUnit::class, $updatedParameters);
        self::assertSame(['class' => StringNormalizableThroughLookupType::class], $updatedParameters[CalendarUnit::class]);

        self::assertArrayHasKey(CalendarPeriod::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[CalendarPeriod::class]);

        self::assertArrayHasKey(DateRange::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[DateRange::class]);

        self::assertArrayHasKey(MomentRange::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[MomentRange::class]);

        self::assertArrayHasKey(TimeRange::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[TimeRange::class]);

        self::assertArrayHasKey(Moments::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Moments::class]);

        self::assertArrayHasKey(Dates::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Dates::class]);

        self::assertArrayHasKey(Times::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Times::class]);

        self::assertArrayHasKey(Months::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Months::class]);

        self::assertArrayHasKey(Years::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Years::class]);

        self::assertArrayHasKey(Durations::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[Durations::class]);

        self::assertArrayHasKey(CalendarUnits::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[CalendarUnits::class]);

        self::assertArrayHasKey(CalendarPeriods::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[CalendarPeriods::class]);

        self::assertArrayHasKey(DateRanges::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[DateRanges::class]);

        self::assertArrayHasKey(MomentRanges::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[MomentRanges::class]);

        self::assertArrayHasKey(TimeRanges::class, $updatedParameters);
        self::assertSame(['class' => ArrayNormalizableThroughLookupType::class], $updatedParameters[TimeRanges::class]);
    }
}
