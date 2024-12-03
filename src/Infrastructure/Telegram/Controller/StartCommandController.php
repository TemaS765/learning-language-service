<?php

declare(strict_types=1);

namespace App\Infrastructure\Telegram\Controller;

use App\Application\UseCase\Request\SetTelegramChannelIdRequest;
use App\Application\UseCase\SetTelegramChannelIdUseCase;
use App\Domain\Exception\NotFoundException;
use Luzrain\TelegramBotApi\Method;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotBundle\Attribute\OnCommand;
use Luzrain\TelegramBotBundle\TelegramCommand;

final class StartCommandController extends TelegramCommand
{
    public function __construct(private readonly SetTelegramChannelIdUseCase $useCase)
    {
    }

    #[OnCommand('/start')]
    public function __invoke(Type\Message $message, string $arg1 = '', string $arg2 = ''): Method
    {
        $request = new SetTelegramChannelIdRequest((string) $message->chat->id);
        try {
            ($this->useCase)($request);
        } catch (NotFoundException $e) {
            return $this->reply('Не удалось подключиться, так-как напоминание не создано');
        } catch (\Throwable $e) {
            return $this->reply('Ну удалось подключиться');
        }

        return $this->reply("Напоминание успешно подключено Chat ID: {$request->channelId}");
    }
}
