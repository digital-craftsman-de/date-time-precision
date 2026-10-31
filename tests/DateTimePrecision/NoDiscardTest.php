<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DateTimePrecision;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * All value objects and collections are immutable. Therefore, every method that returns a new instance of the same type must be marked
 * with #[\NoDiscard], so that a call without using the result (e.g. `$moment->modify('+1 day');`) results in a warning.
 */
#[CoversNothing]
final class NoDiscardTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function methods_returning_a_new_instance_are_marked_with_no_discard(
        string $className,
    ): void {
        /** @var class-string $className */
        $reflectionClass = new \ReflectionClass($className);

        $methodsWithoutNoDiscard = [];
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isStatic()
                || $className !== $method->getDeclaringClass()->getName()
            ) {
                continue;
            }

            $returnType = $method->getReturnType();
            if (!$returnType instanceof \ReflectionNamedType
                || !in_array($returnType->getName(), ['self', 'static', $className], true)
            ) {
                continue;
            }

            if ($method->getAttributes(\NoDiscard::class) === []) {
                $methodsWithoutNoDiscard[] = $method->getName();
            }
        }

        self::assertSame([], $methodsWithoutNoDiscard);
    }

    /**
     * @return array<string, array{
     *   0: string,
     * }>
     */
    public static function dataProvider(): array
    {
        $files = glob(__DIR__.'/../../src/*.php');
        self::assertNotFalse($files);

        $classNames = [];
        foreach ($files as $file) {
            $className = sprintf('DigitalCraftsman\\DateTimePrecision\\%s', basename($file, '.php'));
            if (!class_exists($className)
                && !enum_exists($className)
            ) {
                continue;
            }

            $classNames[$className] = [$className];
        }

        return $classNames;
    }
}
