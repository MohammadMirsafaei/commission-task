<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use DateTime;

class Withdraw extends Transaction
{
    /**
     * @param DateTime $createAt
     * @param \Mirsafaei\CommissionTask\Core\Client $client
     * @param float $amount
     * @param \Mirsafaei\CommissionTask\Core\Currency $currency
     */
    public function __construct(DateTime $createAt, Client $client, float $amount, Currency $currency)
    {
        parent::__construct($createAt, $client, $amount, $currency);
    }

    /**
     * Calculates commision fee of transaction
     * @return string
     */
    public function calculateCommisionFee(): string 
    {
        if($this->getClient()->getType() == Client::BUSINESS_CLIENT) {
            return $this->calculateBusinessCommisionFee();
        }

        return $this->calculatePrivateCommisionFee();
    }

    /**
     * Calculates commision fee for business clients
     * @return string
     */
    private function calculateBusinessCommisionFee(): string
    {
        return bcmul(
            number_format($this->getAmount(), $this->getCurrency()->getPrecision(), '.', ''),
            '0.005',
            $this->getCurrency()->getPrecision()
        );
    }

    /**
     * Calculates commision fee for private clients
     * @return string
     */
    private function calculatePrivateCommisionFee(): string
    {
        // Getting tansaction's week transactions
        $weekTransactions = $this->getClient()->getTransactionsOfWeek($this->getCreatedAt());

        // Free of charge only for the first 3 withdraw operations per a week
        if(count($weekTransactions) >= 3) {
            return bcmul(
                number_format($this->getAmount(), $this->getCurrency()->getPrecision(), '.', ''),
                '0.003',
                $this->getCurrency()->getPrecision()
            );
        }

        // Calculating exceeded amount
        $amount = $this->calculateExceededAmount($weekTransactions);
        return bcmul(
            number_format($amount, $this->getCurrency()->getPrecision(), '.', ''),
            '0.003',
            $this->getCurrency()->getPrecision()
        ); 

    }

    /**
     * Calculates exceeded amount that commision must be applied to
     * @param \Mirsafaei\CommissionTask\Core\Transaction[] $weekTransactions
     * @return float
     */
    private function calculateExceededAmount(array $weekTransactions): float
    {
        $maxAmount = 1000;
        $usedAmount = 0;
        foreach($weekTransactions as $transaction) {
            $usedAmount += $transaction->getAmount();
        }
        return ($usedAmount - $maxAmount <= 0)? 0 : $usedAmount - $maxAmount;
    }
    
}