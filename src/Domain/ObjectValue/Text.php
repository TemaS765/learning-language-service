<?php

declare(strict_types=1);

namespace App\Domain\ObjectValue;

class Text
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValue($value);
        $this->value = $value;
    }

    public function assertValue(string $text): void
    {
        if (mb_strlen($text) > 255 && mb_strlen($text) < 1) {
            throw new \InvalidArgumentException('Invalid text value');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
