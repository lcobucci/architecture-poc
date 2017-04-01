<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

use Ramsey\Uuid\UuidInterface;

final class App
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    public function __construct(UuidInterface $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rename(string $name): void
    {
        $this->name = $name;
    }
}
