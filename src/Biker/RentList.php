<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

interface RentList
{
    /**
     * @throws RentNotFound
     */
    public function get(UuidInterface $id): Rent;

    public function append(Rent $rent): void;
}
