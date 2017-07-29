<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

interface TransactionList
{
    public function findByRider(UuidInterface $riderId): array;

    public function append(Transaction $transaction): void;
}
