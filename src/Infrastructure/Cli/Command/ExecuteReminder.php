<?php

namespace App\Infrastructure\Cli\Command;

use App\Application\UseCase\ExecuteRemindersUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:reminder:execute',
    description: 'Выполнение напоминаний',
)]
class ExecuteReminder extends Command
{
    public function __construct(private ExecuteRemindersUseCase $useCase)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            ($this->useCase)();
            sleep(3);
        }
        return Command::SUCCESS;
    }
}
