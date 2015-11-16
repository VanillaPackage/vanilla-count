<?php

namespace Rentalhost\VanillaCount\Test;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Currency\RealCurrency;
use Rentalhost\VanillaCount\Locale\PortugueseLocale;

/**
 * Class RealCurrencyTest
 * @package Rentalhost\VanillaCount\Test
 */
class RealCurrencyTest extends TestCase
{
    /**
     * Simple tests.
     *
     * @covers \Rentalhost\VanillaCount\Currency\RealCurrency::__construct
     */
    public function testSimple()
    {
        static::writeAttribute(RealCurrency::class, 'instances', [ ]);

        $count = new Count(new PortugueseLocale());

        static::assertSame('um real', $count->spell(1, Count::SPELLING_CURRENCY));
        static::assertSame('dois reais', $count->spell(2, Count::SPELLING_CURRENCY));

        $count = new Count(new PortugueseLocale([ 'currencyLocale' => 'en' ]));

        static::assertSame('um real', $count->spell(1, Count::SPELLING_CURRENCY));
        static::assertSame('dois reais', $count->spell(2, Count::SPELLING_CURRENCY));

        $count = new Count(new PortugueseLocale([ 'currencyLocale' => 'es' ]));

        static::assertSame('um real', $count->spell(1, Count::SPELLING_CURRENCY));
        static::assertSame('dois reais', $count->spell(2, Count::SPELLING_CURRENCY));
    }
}
