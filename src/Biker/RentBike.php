<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\UuidInterface;

final class RentBike
{
    private const MINIMUM_CREDIT = 12;

    /**
     * @var RiderList
     */
    private $riders;

    /**
     * @var BikeList
     */
    private $bikes;

    /**
     * @var RentList
     */
    private $rents;

    /**
     * @var TransactionList
     */
    private $transactions;

    public function __construct(RiderList $riders, BikeList $bikes, RentList $rents, TransactionList $transactions)
    {
        $this->riders = $riders;
        $this->bikes = $bikes;
        $this->rents = $rents;
        $this->transactions = $transactions;
    }

    public function handle(Message\RentBike $command): void
    {
        $this->ensureRiderCredit($command->riderId);

        $rent = Rent::forRider(
            $command->id,
            $this->riders->get($command->riderId),
            $this->bikes->get($command->bikeId)
        );

        $this->rents->append($rent);
    }

    private function ensureRiderCredit(UuidInterface $riderId): void
    {
        $balance = array_sum(
            array_map(
                function (Transaction $transaction): float {
                    return $transaction->amount();
                },
                $this->transactions->findByRider($riderId)
            )
        );

        if ($balance < self::MINIMUM_CREDIT) {
            throw new \RuntimeException('Not enough credit');
        }
    }
}
