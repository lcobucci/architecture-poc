<?php
declare(strict_types=1);

namespace Lcobucci\Sample\Biker\Repository;

use Lcobucci\Sample\Biker\RiderList;
use Lcobucci\Sample\Biker\Transaction;
use Lcobucci\Sample\Biker\TransactionList;
use Lcobucci\Sample\NaiveJsonRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class JsonTransactions extends NaiveJsonRepository implements TransactionList
{
    /**
     * @var RiderList
     */
    private $riders;

    public function __construct(string $filename, RiderList $riders)
    {
        $this->riders = $riders;

        parent::__construct($filename);
    }

    public function findByRider(UuidInterface $riderId): array
    {
        return array_filter(
            $this->items,
            function (Transaction $transaction) use ($riderId): bool {
                return $transaction->belongsTo($riderId);
            }
        );
    }

    public function append(Transaction $transaction): void
    {
        $this->items[] = $transaction;
        $this->changed = true;
    }

    protected function convertItemToObject(array $item)
    {
        return new Transaction(
            Uuid::fromString($item['id']),
            $this->riders->get(Uuid::fromString($item['rider'])),
            new \DateTimeImmutable($item['date']),
            $item['amount']
        );
    }

    /**
     * @param Transaction $object
     */
    protected function convertObjectToItem($object): array
    {
        return [
            'id'     => (string) $object->id(),
            'rider'  => (string) $object->riderId(),
            'date'   => $object->date()->format(\DateTime::RFC3339),
            'amount' => $object->amount(),
        ];
    }
}
