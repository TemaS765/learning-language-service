<?php

declare(strict_types=1);

namespace App\Domain\ObjectValue;

class Id
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertValue($value);
        $this->value = $value;
    }

    public function assertValue(int $value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Invalid id value');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
