<?php

declare(strict_types=1);

namespace Mirsafaei\CommissionTask\Tests\Core;

use Mirsafaei\CommissionTask\Core\Core;
use Mirsafaei\CommissionTask\Core\Currency;
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
    }
    public function testAddingNewCurrency()
    {
        $this->core->addCurrency(new Currency('EUR'));
        array_walk($this->core->getCurrencies(), function(Currency $item) {
            $this->assertEquals($item->getName(), 'EUR', 'EUR present in currencies');
        });
    }
}