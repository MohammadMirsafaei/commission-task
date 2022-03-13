<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use DateTime;

class Withdraw extends Transaction
{
    /**
     * @param \DateTime $createAt
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
        return $this->customRound(
            $this->getAmount() * 0.005,
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
        $weekWithdraws = $this->getClient()->getWithdrawsOfWeekOfWeek($this->getCreatedAt());

        // Free of charge only for the first 3 withdraw operations per a week
        if(count($weekWithdraws) >= 3 || $this->maxFreeChargeReached($weekWithdraws)) {
            return $this->customRound(
                $this->getAmount() * 0.003,
                $this->getCurrency()->getPrecision()
            );
        }

        // Calculating exceeded amount
        $amount = $this->calculateExceededAmount($weekWithdraws) * $this->getCurrency()->getRate();
        return $this->customRound(
            $amount * 0.003,
            $this->getCurrency()->getPrecision()
        );

    }

    /**
     * Checks if total amount of withdraws are more than 1000 EUR
     * @param \Mirsafaei\CommissionTask\Core\Transaction[] $weekWithdraws
     * @return bool
     */
    private function maxFreeChargeReached(array $weekWithdraws): bool
    {
        $usedAmount = 0;
        foreach($weekWithdraws as $transaction) {
            $usedAmount += ($transaction->getAmount() / $transaction->getCurrency()->getRate());
        }
        if ($usedAmount > 1000)
            return true;
        return false;
    }

    /**
     * Calculates exceeded amount that commision must be applied to
     * @param \Mirsafaei\CommissionTask\Core\Transaction[] $weekWithdraws
     * @return float
     */
    private function calculateExceededAmount(array $weekWithdraws): float
    {
        $maxAmount = 1000;
        $usedAmount = 0;
        foreach($weekWithdraws as $transaction) {
            $usedAmount += ($transaction->getAmount() / $transaction->getCurrency()->getRate());
        }
        $usedAmount += ($this->getAmount() / $this->getCurrency()->getRate());
        return ($usedAmount - $maxAmount <= 0)? 0 : $usedAmount - $maxAmount;
    }
    
}