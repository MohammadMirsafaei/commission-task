<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

use DateTime;
use Mirsafaei\CommissionTask\Exceptions\CurrencyNotSupportedException;
use PHPUnit\Framework\DataProviderTestSuite;

class Core
{
    /**
     * @var Core|null
     */
    private static $instance;

    /**
     * @var Currency[]
     */
    private static array $currencies = [];

    /**
     * @var Client[]
     */
    private static array $clients = [];

    private function __construct() { }

    /**
     * Returns instance or create it if there is none
     * @return Core
     */
    public static function getInstance(): Core
    {
        if(!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }


    /**
     * Adds new currency to list of supported currencies
     * @param Currency $currency
     * @return string
     */
    public function addCurrency(Currency $currency)
    {
        if(!in_array($currency->getName(), array_column(self::$currencies, 'name'))) {
            self::$currencies[] = $currency;
        }
    }

    /**
     * Retuens list of loaded currencies
     * @return Currency[]
     */
    public function getCurrencies(): array
    {
        return self::$currencies;
    }

    /**
     * Adds new client to list if needed
     * @param int $id
     * @param string $type
     * @return Client
     */
    public function &addClient(int $id, string $type)
    {
        $client = new Client($id, ($type === 'private') ? Client::PRIVATE_CLIENT : Client::BUSINESS_CLIENT);
        foreach (self::$clients as $c) {
            if ($c->getId() === $client->getId()) {
                return $c;
            }
        }
        self::$clients[] = $client;
        return self::$clients[count(self::$clients)-1];
    }

    /**
     * Finds client
     * @param int $id
     * @return Client
     */
    public function &findClient(int $id): Client
    {
        foreach (self::$clients as $client) {
            if ($client->getId() === $id) {
                return $client;
            }
        }
    }

    /**
     * Finds currency
     * @param string $name
     * @return Currency
     * @throws CurrencyNotSupportedException
     */
    public function findCurrency(string $name): Currency
    {
        foreach (self::$currencies as $currency) {
            if ($currency->getName() === $name) {
                return $currency;
            }
        }
        throw new CurrencyNotSupportedException("Currency '{$name}' is not supported.");
    }

    /**
     * Adds new transaction
     * @param int $id
     * @param string $type
     * @return Transaction
     */
    public function &addTransaction(int $id, string $createdAt, string $transactionType, float $amount, string $currency): Transaction
    {
        $client = &$this->findClient($id);
        if ($transactionType === 'deposit') {
            $transaction = new Deposit(new DateTime($createdAt), $client, $amount, $this->findCurrency($currency));
        } else {
            $transaction = new Withdraw(new DateTime($createdAt), $client, $amount, $this->findCurrency($currency));
        }
        return $transaction;

    }
    
}