<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

final class Bike
{
    private $id;

    private $locked;

    public function __construct(UuidInterface $id, bool $locked)
    {
        $this->id     = $id;
        $this->locked = $locked;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function lock(): void
    {
        if ($this->locked) {
            throw new \RuntimeException('You cannot lock a locked bike');
        }

        $this->locked = true;
    }

    public function unlock(): void
    {
        if (! $this->locked) {
            throw new \RuntimeException('You cannot unlock an unlocked bike');
        }

        $this->locked = false;
    }
}
