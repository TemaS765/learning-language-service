<?php

declare(strict_types=1);

namespace App\Application\Service\Request;

class SendReminderRequest
{
    public function __construct(public string $channelId, public string $question) {
    }
}
