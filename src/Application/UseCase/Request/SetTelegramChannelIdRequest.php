<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class SetTelegramChannelIdRequest
{
    public function __construct(public string $channelId) {
    }
}
