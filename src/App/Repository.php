<?php
declare(strict_types=1);

namespace Lcobucci\Sample\App;

use Ramsey\Uuid\UuidInterface;

interface Repository
{
    public function get(UuidInterface $id): App;

    public function findAll(): array;

    public function append(App $app): void;
}
