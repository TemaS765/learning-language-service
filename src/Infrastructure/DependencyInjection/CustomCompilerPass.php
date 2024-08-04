<?php

declare(strict_types=1);

namespace App\Infrastructure\DependencyInjection;

use App\Application\Service\ReminderProviderCollectionInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CustomCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ReminderProviderCollectionInterface::class)) {
            return;
        }

        $definition = $container->findDefinition(ReminderProviderCollectionInterface::class);
        $taggedServices = $container->findTaggedServiceIds('app.reminder_provider');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
