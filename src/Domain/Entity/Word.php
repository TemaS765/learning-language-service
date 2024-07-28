<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ObjectValue\Id;
use App\Domain\ObjectValue\Text;

class Word
{
    private ?Id $id;
    private Text $text;
    private Text $translate;

    public function __construct(Text $text, Text $translate)
    {
        $this->text = $text;
        $this->translate = $translate;
    }

    public function getId(): ?Id
    {
        return $this->id;
    }

    public function getText(): Text
    {
        return $this->text;
    }

    public function getTranslate(): Text
    {
        return $this->translate;
    }
}
