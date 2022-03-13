<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use DateInterval;
use DateTime;

class Client
{
    public const PRIVATE_CLIENT = 1;

    public const BUSINESS_CLIENT = 2;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $clientType;

    /**
     * @var \Mirsafaei\CommissionTask\Core\Transaction[]
     */
    private array $transactions = [];
    
    /**
     * @param int $id
     * @param int $clientType
     */
    public function __construct(int $id, int $clientType)
    {
        $this->id = $id;
        $this->clientType = $clientType;
    }

    /**
     * Returns id of client
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns type of client
     * @return int
     */
    public function getType(): int
    {
        return $this->clientType;
    }
    
    /**
     * Returns transactions of client
     * @return \Mirsafaei\CommissionTask\Core\Transaction[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * Returns withdraws of week of provided date
     * @return \Mirsafaei\CommissionTask\Core\Transaction[]
     */
    public function getWithdrawsOfWeekOfWeek(DateTime $date): array
    {
        // Finding start and end of week
        $startDate = DateTime::createFromFormat(
            'U', 
            (string)strtotime("{$date->format('o')}-W{$date->format('W')}-1")
        );
        $endDate = DateTime::createFromFormat(
            'Y-m-d',
            $startDate->format('Y-m-d')
        )->add(DateInterval::createFromDateString('6 days'));

        // Filtering results
        return array_filter(
            $this->transactions, 
            function(Transaction $transaction) use ($startDate, $endDate) {
                if($transaction->getCreatedAt() >= $startDate
                    && $transaction->getCreatedAt() <= $endDate
                    && is_a($transaction, Withdraw::class)) {
                    return true;
                }
                return false;
        });
    }

    /**
     * Adds transaction to list of transactions
     * @param Transaction $transaction
     */
    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
    }
}