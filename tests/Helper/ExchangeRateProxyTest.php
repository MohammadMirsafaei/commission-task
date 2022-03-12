<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Tests\Helper;

use Mirsafaei\CommissionTask\Core\Currency;
use PHPUnit\Framework\TestCase;
use Mirsafaei\CommissionTask\Helper\ExchangeRateProxy;

class ExchangeRateProxyTest extends TestCase
{
    /**
     * Tests structure of response
     */
    public function testFetchingExchangeRates()
    {
        $rate = ExchangeRateProxy::getExchageRate((new Currency('AED'))->getName());
        $this->assertTrue(is_float($rate), 'returned rate is float');
    }

    
}