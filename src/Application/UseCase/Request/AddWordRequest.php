<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class AddWordRequest
{
    public function __construct(public string $text, public string $translate)
    {
    }
}
