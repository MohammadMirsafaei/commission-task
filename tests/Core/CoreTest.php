<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Tests\Core;

use Mirsafaei\CommissionTask\Core\Client;
use Mirsafaei\CommissionTask\Core\Core;
use Mirsafaei\CommissionTask\Core\Currency;
use Mirsafaei\CommissionTask\Helper\ExchangeRateProxy;
use Mirsafaei\CommissionTask\Tests\CsvFileIterator;
use PHPUnit\Framework\TestCase;

class CoreTest extends TestCase
{
    /**
     * @var Core
     */
    private Core $core;

    public function setUp()
    {
        $this->core = Core::getInstance();
        $this->core->addCurrency(new Currency('EUR'));
        $this->core->addCurrency(new Currency('USD'));
        $this->core->addCurrency(new Currency('JPY', 0));

        ExchangeRateProxy::setTestMode();
    }

    /**
     * @param string $createdAt
     * @param int $id
     * @param string $clientType
     * @param string $transactionType
     * @param float $amount
     * @param string $currency 
     * @param string $expectation 
     * 
     * @dataProvider dataProviderForCalculatingFileTesting
     */
    public function testCalculatingFile(string $createdAt, int $id, string $clientType, string $transactionType, float $amount, string $currency, string $expectation)
    {
        $client = &$this->core->addClient($id, $clientType);
        $transaction = &$this->core->addTransaction($id, $createdAt, $transactionType, $amount, $currency);
        
        $this->assertTrue(
            $expectation === $transaction->calculateCommisionFee()
        );
        
        $client->addTransaction($transaction);
    }

    public function dataProviderForCalculatingFileTesting()
    {
        return new CsvFileIterator(dirname(__FILE__) . '/input.csv');
    }


}