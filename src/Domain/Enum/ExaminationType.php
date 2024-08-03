<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ExaminationType: string {
    case EXAM = 'exam';
    case TRAIN = 'train';
}

