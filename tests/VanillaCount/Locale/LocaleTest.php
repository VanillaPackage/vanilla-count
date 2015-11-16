<?php

namespace Rentalhost\VanillaCount\Test;

use Rentalhost\VanillaCount\Currency\RealCurrency;
use Rentalhost\VanillaCount\Locale\Locale;
use Rentalhost\VanillaCount\Locale\PortugueseLocale;

/**
 * Class LocaleTest
 * @package Rentalhost\VanillaCount\Locale
 */
class LocaleTest extends TestCase
{
    /**
     * Call getCurrency passing the defaultCurrency option.
     *
     * @param string|RealCurrency $defaultCurrencyOption The value to test load.
     */
    static private function callGetCurrency($defaultCurrencyOption)
    {
        $locale = new PortugueseLocale([ 'defaultCurrency' => $defaultCurrencyOption ]);

        static::assertInstanceOf(RealCurrency::class, static::invokeMethod($locale, 'getCurrency'));
    }

    /**
     * Test load currency by prebuild string classes, class names or instance.
     *
     * @param string|RealCurrency $defaultCurrencyOption The value to test load.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\Locale::__construct
     * @covers       \Rentalhost\VanillaCount\Locale\Locale::getCurrency
     *
     * @dataProvider dataCurrencyValids
     */
    public function testCurrencyValids($defaultCurrencyOption)
    {
        static::callGetCurrency($defaultCurrencyOption);
    }

    /**
     * Data provider.
     */
    public function dataCurrencyValids()
    {
        return [
            [ 'real' ],
            [ RealCurrency::class ],
            [ RealCurrency::getInstance() ],
        ];
    }

    /**
     * Test load an unsupported currency.
     *
     * @param string|RealCurrency $defaultCurrencyOption The value to test load.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\Locale::getCurrency
     *
     * @dataProvider dataCurrencyUnsupportedException
     * @expectedException \Rentalhost\VanillaCount\Exception\CurrencyUnsupportedException
     */
    public function testCurrencyUnsupportedException($defaultCurrencyOption)
    {
        static::callGetCurrency($defaultCurrencyOption);
    }

    /**
     * Data provider.
     */
    public function dataCurrencyUnsupportedException()
    {
        return [
            [ 'unsupported' ],
            [ PortugueseLocale::class ],
        ];
    }

    /**
     * Test getLocale method.
     *
     * @covers \Rentalhost\VanillaCount\Locale\Locale::getLocale
     */
    public function testGetLocale()
    {
        // Basic.
        static::assertInstanceOf(PortugueseLocale::class, Locale::getLocale(new PortugueseLocale()));
        static::assertInstanceOf(PortugueseLocale::class, Locale::getLocale('portuguese'));

        // With options.
        $locale = Locale::getLocale(new PortugueseLocale([ 'option' => 'original' ]), [ 'option' => 'rewrited' ]);

        static::assertInstanceOf(PortugueseLocale::class, $locale);
        static::assertSame('rewrited', static::readAttribute($locale, 'options')->option);

        $locale = Locale::getLocale('portuguese', [ 'option' => 'value' ]);

        static::assertInstanceOf(PortugueseLocale::class, $locale);
        static::assertSame('value', static::readAttribute($locale, 'options')->option);
    }

    /**
     * Teste LocaleUnsupportedException exception.
     *
     * @expectedException \Rentalhost\VanillaCount\Exception\LocaleUnsupportedException
     */
    public function testLocaleUnsupportedException()
    {
        Locale::getLocale('unknowLocale');
    }
}
