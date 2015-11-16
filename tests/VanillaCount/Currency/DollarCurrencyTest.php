<?php

namespace Rentalhost\VanillaCount\Test;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Currency\DollarCurrency;
use Rentalhost\VanillaCount\Locale\PortugueseLocale;

/**
 * Class DollarCurrencyTest
 * @package Rentalhost\VanillaCount\Test
 */
class DollarCurrencyTest extends TestCase
{
    /**
     * Simple tests.
     *
     * @covers \Rentalhost\VanillaCount\Currency\DollarCurrency::__construct
     */
    public function testSimple()
    {
        static::writeAttribute(DollarCurrency::class, 'instances', [ ]);

        $count = new Count(new PortugueseLocale([ 'currency' => DollarCurrency::class ]));

        static::assertSame('um dólar', $count->spell(1, Count::SPELLING_CURRENCY));
        static::assertSame('dois dólares', $count->spell(2, Count::SPELLING_CURRENCY));

        $count = new Count(new PortugueseLocale([ 'currency' => DollarCurrency::class, 'currencyLocale' => 'en' ]));

        static::assertSame('um dollar', $count->spell(1, Count::SPELLING_CURRENCY));
        static::assertSame('dois dollars', $count->spell(2, Count::SPELLING_CURRENCY));

        $count = new Count(new PortugueseLocale([ 'currency' => DollarCurrency::class, 'currencyLocale' => 'es' ]));

        static::assertSame('um dólar', $count->spell(1, Count::SPELLING_CURRENCY));
        static::assertSame('dois dólares', $count->spell(2, Count::SPELLING_CURRENCY));
    }
}
