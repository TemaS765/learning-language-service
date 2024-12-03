<?php

namespace App;

use App\Infrastructure\DependencyInjection\CustomCompilerPass;
use App\Infrastructure\Doctrine\Type\ExaminationEnumType;
use App\Infrastructure\Doctrine\Type\ReminderChannelTypeEnumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function initializeContainer(): void
    {
        parent::initializeContainer();
        $this->registerCustomDBALTypes();
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CustomCompilerPass());
    }

    private function registerCustomDBALTypes(): void
    {
        /** @var EntityManagerInterface $m */
        $m = $this->container->get('doctrine.orm.entity_manager');
        $platform = $m->getConnection()->getDatabasePlatform();

        $platform->registerDoctrineTypeMapping(ExaminationEnumType::NAME, ExaminationEnumType::NAME);
        $platform->registerDoctrineTypeMapping(ReminderChannelTypeEnumType::NAME, ReminderChannelTypeEnumType::NAME);
    }
}
