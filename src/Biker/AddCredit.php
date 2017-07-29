<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker;

final class AddCredit
{
    /**
     * @var RiderList
     */
    private $riders;

    /**
     * @var TransactionList
     */
    private $transactions;

    public function __construct(RiderList $riders, TransactionList $transactions)
    {
        $this->riders = $riders;
        $this->transactions = $transactions;
    }

    public function handle(Message\AddCredit $command): void
    {
        $rider = $this->riders->get($command->riderId);

        $this->transactions->append(Transaction::credit($command->id, $rider, $command->amount));
    }
}
