<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Helper;

use GuzzleHttp\Client;
use Mirsafaei\CommissionTask\Core\Currency;
use Mirsafaei\CommissionTask\Exceptions\NoExchangeFeeAvilableException;

class ExchangeRateProxy
{
    /**
     * @var string
     */
    private const API_URL = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';

    /**
     * @var bool
     */
    private static bool $testMode = false;
    
    /**
     * Fetches all exchange rates from API using http request
     * @return array
     */
    private static function fetchExchangeRatesFormAPI(): array
    {
        if (self::$testMode) {
            return [
                'EUR' => 1,
                'USD' => 1.1497,
                'JPY' => 129.53
            ];
        }
        $client = new Client();
        $response = $client->request('GET', self::API_URL);
        return json_decode((string) $response->getBody(), true)['rates'];
    }

    /**
     * Returns exhcange rate of currecy to EUR
     * @param string $currencyName
     * @throws \Mirsafaei\CommissionTask\Exceptions\NoExchangeFeeAvilableException
     * @return string
     */
    public static function getExchageRate(string $currencyName): float
    {
        $rates = self::fetchExchangeRatesFormAPI();
        if(!array_key_exists($currencyName, $rates)) {
            throw new NoExchangeFeeAvilableException("There is no exhcange fee avilable for '{$currencyName}'.");
        }
        return $rates[$currencyName];
    }

    /**
     * Sets mode to test 
     */
    public static function setTestMode()
    {
        self::$testMode = true;
    }
    
}