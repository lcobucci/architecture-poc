<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App\Message;

use Lcobucci\SecretSauce\ModelConversion\Query;

final class RetrieveApps implements Query
{
    public static function fromRequest(): self
    {
        return new self();
    }

    public function getReadModelConverter(): callable
    {
        return [App::class, 'fromEntity'];
    }
}
