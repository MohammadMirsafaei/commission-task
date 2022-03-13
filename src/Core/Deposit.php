<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use DateTime;

class Deposit extends Transaction
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
        return bcmul(
            number_format($this->getAmount(), $this->getCurrency()->getPrecision(), '.', ''),
            '0.0003',
            $this->getCurrency()->getPrecision()
        );
    }
    
}