<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/** @codeCoverageIgnore */
final class DateTimePrecisionExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        if ($container->getParameter('kernel.environment') === 'test') {
            $loader->load('services_test.yaml');
        }
    }
}
