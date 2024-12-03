<?php

declare(strict_types=1);

namespace App\Infrastructure\Telegram\Controller;

use App\Application\UseCase\CheckReminderExerciseUseCase;
use App\Application\UseCase\Request\CheckReminderExerciseRequest;
use App\Domain\Exception\NotFoundException;
use Luzrain\TelegramBotApi\Method;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotBundle\Attribute\OnCommand;
use Luzrain\TelegramBotBundle\TelegramCommand;

final class AnswerCommandController extends TelegramCommand
{
    public function __construct(private readonly CheckReminderExerciseUseCase $useCase)
    {
    }

    #[OnCommand('/answer')]
    public function __invoke(Type\Message $message, string $arg1 = '', string $arg2 = ''): Method
    {
        $answer = explode(' ', $message->text, 2)[1] ?? '';
        if (empty($answer)) {
            return $this->reply('Передано пустое значение');
        }

        $request = new CheckReminderExerciseRequest($answer);

        try {
            $response = ($this->useCase)($request);
        } catch (NotFoundException $e) {
            return $this->reply('Не удалось подключиться, так-как напоминание не создано');
        } catch (\Throwable $e) {
            return $this->reply('Ну удалось подключиться');
        }

        return $this->reply(
            'Ответ --- <strong>' . ($response->isCorrect ? 'Верный' : 'Неверный') . '</strong>',
            'HTML'
        );
    }
}
