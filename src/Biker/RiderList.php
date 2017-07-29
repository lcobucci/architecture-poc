<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

interface RiderList
{
    /**
     * @throws RiderNotFound
     */
    public function get(UuidInterface $id): Rider;
}
