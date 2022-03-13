<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Tests\Core;

use DateTime;
use Mirsafaei\CommissionTask\Core\Client;
use PHPUnit\Framework\TestCase;
use Mirsafaei\CommissionTask\Core\Currency;
use Mirsafaei\CommissionTask\Core\Deposit;
use Mirsafaei\CommissionTask\Core\Transaction;

class DepositTest extends TestCase
{
    /**
     * @param \Mirsafaei\CommissionTask\Core\Transaction $transaction
     * @param string $expectation
     *
     * @dataProvider dataProviderForCalculatingDepositCommisionFeeTesting
     */
    public function testCalculatingDepositCommisionFee(Transaction $transaction, string $expectation)
    {
        $this->assertTrue(
            $expectation === "{$transaction->calculateCommisionFee()}"
        );
    }

    public function dataProviderForCalculatingDepositCommisionFeeTesting(): array
    {
        return [
            'deposit of 200 EUR' => [
                new Deposit(
                    new DateTime('2016-01-05'),
                    new Client(1,Client::PRIVATE_CLIENT),
                    200.00,
                    new Currency('EUR', 2)
                ),
                '0.06'
            ],
            'deposit of 10000.00 EUR' => [
                new Deposit(
                    new DateTime('2016-01-05'),
                    new Client(1,Client::PRIVATE_CLIENT),
                    10000.00,
                    new Currency('EUR', 2)
                ),
                '3.00'
            ]
        ];
    }

    public function testCalculatingDepositCommisionFeeThatFails()
    {
        $this->assertFalse(
            (new Deposit(
                new DateTime('2016-01-05'),
                new Client(1,Client::PRIVATE_CLIENT),
                10000.00,
                new Currency('EUR', 2)
            ))->calculateCommisionFee() === '2.99999999999',
            'testing that 2.99999999 is not equal to 3.00'
        );
    }
    
}