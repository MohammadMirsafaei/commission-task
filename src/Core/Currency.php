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
     * @var int
     */
    private int $precision;
    
    /**
     * @param string $name
     * @param int $precision
     */
    public function __construct(string $name, int $precision = 2)
    {
        $this->name = $name;
        $this->precision = $precision;
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
     * Returns precision of currency
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
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