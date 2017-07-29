<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

final class RentNotFound extends \RuntimeException
{
    public static function forId(UuidInterface $id): self
    {
        return new self(sprintf('No rent with id "%s" was found', (string) $id));
    }
}
