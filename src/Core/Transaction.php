<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use DateTime;

abstract class Transaction
{
    /**
     * @var DateTime
     */
    private DateTime $createAt;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var float
     */
    private float $amount;

    /**
     * @var Currency
     */
    private Currency $currency;
    
    /**
     * @param DateTime $createAt
     * @param \Mirsafaei\CommissionTask\Core\Client $client
     * @param float $amount
     * @param \Mirsafaei\CommissionTask\Core\Currency $currency
     */
    protected function __construct(DateTime $createAt, Client &$client, float $amount, Currency $currency)
    {
        $this->createAt = $createAt;
        $this->client = &$client;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * Returns creation date of transaction
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createAt;
    }

    /**
     * Returns client of transaction
     * @return \Mirsafaei\CommissionTask\Core\Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Returns amout of transaction
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Returns currency of transaction
     * @return \Mirsafaei\CommissionTask\Core\Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * Calculates commision fee of transaction
     * @return string
     */
    abstract public function calculateCommisionFee(): string;
    
}