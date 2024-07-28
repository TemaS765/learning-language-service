<?php

namespace App\Tests\Integration\Infrastructure\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WordRepositoryTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        print_r($_ENV);
        exit();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
