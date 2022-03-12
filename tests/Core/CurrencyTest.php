<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Tests\Core;

use PHPUnit\Framework\TestCase;
use Mirsafaei\CommissionTask\Core\Currency;

class CurrencyTest extends TestCase
{
    /**
     * @param string $providedName
     * @param string $expectation
     *
     * @dataProvider dataProviderForConstructingCurrencyTesting
     */
    public function testConstructingCurrency(string $providedName, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            (new Currency($providedName))->getName()
        );
    }

    public function dataProviderForConstructingCurrencyTesting(): array
    {
        return [
            'adding EUR' => ['EUR', 'EUR'],
            'adding USD' => ['USD', 'USD'],
            'adding JPY' => ['JPY', 'JPY'],
        ];
    }

    /**
     * Tests return type of exchange rate
     */
    public function testReturnTypeOfExchangeRate()
    {
        $this->assertTrue(
            is_float((new Currency('EUR'))->getRate()), 
            'EUR rate be float'
        );
        $this->assertTrue(
            is_float((new Currency('USD'))->getRate()), 
            'USD rate be float'
        );
        $this->assertTrue(
            is_float((new Currency('JPY'))->getRate()), 
            'JPY rate be float'
        );
    }
}