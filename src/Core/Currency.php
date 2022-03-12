<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use Mirsafaei\CommissionTask\Helper\ExchangeRateProxy;

class Currency
{
    /**
     * @var string
     */
    private string $name;
    
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns name of currency
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns exchange rate of currency to EUR
     * @return float
     */
    public function getRate()
    {
        return ExchangeRateProxy::getExchageRate($this->name);
    }
    
}