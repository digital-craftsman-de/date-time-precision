<?php

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\DateTimePrecision\DependencyInjection\DoctrineTypeRegisterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @codeCoverageIgnore
 */
final class DateTimePrecisionBundle extends Bundle
{
    #[\Override]
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new DoctrineTypeRegisterCompilerPass());
    }
}
