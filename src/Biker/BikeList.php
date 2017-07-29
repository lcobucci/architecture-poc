<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

interface BikeList
{
    /**
     * @throws BikeNotFound
     */
    public function get(UuidInterface $id): Bike;
}
