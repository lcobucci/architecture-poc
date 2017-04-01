<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App\Message;

final class RetrieveApps
{
    public static function fromRequest(): self
    {
        return new self();
    }
}
