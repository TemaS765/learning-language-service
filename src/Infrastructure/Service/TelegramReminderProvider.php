<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\ReminderProviderInterface;
use App\Application\Service\Request\SendReminderRequest;
use App\Domain\Enum\ReminderChannelType;
use Luzrain\TelegramBotApi\BotApi;
use Luzrain\TelegramBotApi\Exception\TelegramApiException;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Psr\Http\Client\ClientExceptionInterface;

class TelegramReminderProvider implements ReminderProviderInterface
{
    public function __construct(private BotApi $botApi)
    {
    }

    public function getType(): ReminderChannelType
    {
        return ReminderChannelType::TELEGRAM;
    }

    /**
     * @throws TelegramApiException
     * @throws ClientExceptionInterface
     */
    public function send(SendReminderRequest $request): void
    {
        $text = "❕❕❕ Проверка ❕❕❕\n\n<strong>Привет</strong>     ➡️➡️➡️      ___________\n";
        $method = new SendMessage(
            $request->channelId,
            $text,
            null,
            null,
            'HTML'
        );
        $this->botApi->call($method);
    }
}

