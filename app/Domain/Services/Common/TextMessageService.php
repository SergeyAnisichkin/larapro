<?php

declare(strict_types=1);

namespace App\Domain\Services\Common;

use App\Domain\Repositories\Main\Common\TextRepository;

class TextMessageService
{
    public function __construct(
        private readonly TextRepository $textRepository,
    ) {
    }

    public function getText(string $key): string
    {
        return $this->textRepository->findByKey($key);
    }
}