<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

final class RetrieveRent
{
    /**
     * @var RentList
     */
    private $rents;

    public function __construct(RentList $rents)
    {
        $this->rents = $rents;
    }

    public function handle(Message\RetrieveRent $query): Rent
    {
        return $this->rents->get($query->id);
    }
}
