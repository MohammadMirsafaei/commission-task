<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Core;

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
     * @param Client $client
     */
    public function addClient(Client $client)
    {
        foreach (self::$clients as $c) {
            if ($c->getId() === $client->getId()) {
                return;
            }
        }
        self::$clients[] = $client;
    }
    
}