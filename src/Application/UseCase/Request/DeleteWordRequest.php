<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class DeleteWordRequest
{
    public function __construct(public int $id)
    {
    }
}
