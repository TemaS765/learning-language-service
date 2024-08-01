<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class EditWordRequest
{
    public function __construct(public int $id, public string $text, public string $translate)
    {
    }
}
