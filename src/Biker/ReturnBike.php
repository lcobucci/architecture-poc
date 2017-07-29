<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

use Ramsey\Uuid\Uuid;

final class ReturnBike
{
    private $rents;

    private $transactions;

    public function __construct(RentList $rents, TransactionList $transactions)
    {
        $this->rents        = $rents;
        $this->transactions = $transactions;
    }

    public function handle(Message\ReturnBike $command): void
    {
        $rent = $this->rents->get($command->id);

        $rent->giveBack();

        $this->transactions->append(
            Transaction::debit(Uuid::uuid4(), $rent->rider(), $rent->price())
        );
    }
}
