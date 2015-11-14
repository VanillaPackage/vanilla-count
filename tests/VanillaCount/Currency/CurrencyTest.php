<?php

namespace Rentalhost\VanillaCount\Test;

use Closure;
use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Currency\Currency;
use Rentalhost\VanillaCount\Currency\DollarCurrency;
use Rentalhost\VanillaCount\Currency\RealCurrency;

/**
 * Class CurrencyTest
 * @package Rentalhost\VanillaCount\Currency
 */
class CurrencyTest extends TestCase
{
    /**
     * Test getInstance method.
     *
     * @param string|Currency $currencyClass The current class to getInstance.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::getInstance
     *
     * @dataProvider dataGetInstance
     */
    public function testGetInstance($currencyClass)
    {
        static::assertInstanceOf($currencyClass, $currencyClass::getInstance());
    }

    /**
     * Data provider.
     */
    public function dataGetInstance()
    {
        return [
            [ RealCurrency::class ],
            [ DollarCurrency::class ],
        ];
    }

    /**
     * Test getLocaleSplitted method.
     *
     * @param string   $locale          The locale to split.
     * @param string[] $expectedLocales The locales after split.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::getLocaleSplitted
     *
     * @dataProvider dataGetLocaleSplitted
     */
    public function testGetLocaleSplitted($locale, $expectedLocales)
    {
        $abstractCurrency = static::getMockForAbstractClass(Currency::class);

        static::assertSame($expectedLocales, static::invokeMethod($abstractCurrency, 'getLocaleSplitted', [ $locale ]));
    }

    /**
     * Data provider.
     */
    public function dataGetLocaleSplitted()
    {
        return [
            // Empty.
            [ '', [ ] ],

            // Expected.
            [ 'pt', [ 'pt' ] ],
            [ 'pt-BR', [ 'pt', 'pt-BR' ] ],

            // Normalized.
            [ ' PT ', [ 'pt' ] ],
            [ ' pt_BR ', [ 'pt', 'pt-BR' ] ],
            [ ' pt _ BR ', [ 'pt', 'pt-BR' ] ],

            // Example.
            [ 'side1-side2', [ 'side1', 'side1-SIDE2' ] ],

            // Uncommon.
            [ 'pt-BR-Rio de Janeiro', [ 'pt', 'pt-BR', 'pt-BR-Rio de Janeiro' ] ],
            [ 'pt-BR-rj+alternative', [ 'pt', 'pt-BR', 'pt-BR-rj+alternative' ] ],
            [ 'pt-BR-rj-alternative', [ 'pt', 'pt-BR', 'pt-BR-rj-alternative' ] ],
            [ 'pt-BR- rj ', [ 'pt', 'pt-BR', 'pt-BR-rj' ] ],
        ];
    }

    /**
     * Test getLocaleNormalized method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::getLocaleNormalized
     */
    public function testGetLocaleNormalized()
    {
        $abstractCurrency = static::getMockForAbstractClass(Currency::class);

        static::assertSame(null, static::invokeMethod($abstractCurrency, 'getLocaleNormalized', [ null ]));
        static::assertSame('pt', static::invokeMethod($abstractCurrency, 'getLocaleNormalized', [ 'pt' ]));
        static::assertSame('pt-BR', static::invokeMethod($abstractCurrency, 'getLocaleNormalized', [ 'pt.BR' ]));
        static::assertSame('pt-BR-RJ', static::invokeMethod($abstractCurrency, 'getLocaleNormalized', [ 'pt.BR + RJ' ]));
    }

    /**
     * Test addLocale method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::addLocale
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::setDefaultLocale
     */
    public function testAddLocale()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        static::assertSame([ ], static::readAttribute($locale, 'locales'));
        static::assertSame([ ], static::readAttribute($locale, 'defaultLocales'));

        // Add some fakes locales.
        static::invokeMethod($locale, 'addLocale', [ 'fake.locale', null, ]);
        static::invokeMethod($locale, 'addLocale', [ 'fake.locale+alternative', null, ]);

        static::assertSame([ 'fake-LOCALE', 'fake-LOCALE-alternative' ], array_keys(static::readAttribute($locale, 'locales')));
        static::assertSame([ 'fake', 'fake-LOCALE' ], static::readAttribute($locale, 'defaultLocales'));
    }

    /**
     * Test addLocaleAlias method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::addLocaleAlias
     */
    public function testAddLocaleAlias()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        // Add a fake locale.
        static::invokeMethod($locale, 'addLocale', [
            'fake.locale',
            function () {
            },
        ]);

        // Add a fake locale alias.
        static::invokeMethod($locale, 'addLocaleAlias', [
            'fake.alias',
            'fake.locale',
        ]);

        static::assertSame([ 'fake-LOCALE', 'fake-ALIAS' ], array_keys(static::readAttribute($locale, 'locales')));
    }

    /**
     * Test addLocaleAlias method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::addLocaleAlias
     *
     * @expectedException \Rentalhost\VanillaCount\Exception\LocaleUndefinedException
     */
    public function testLocaleUndefinedException()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        // Add a fake locale alias on an undefined base.
        static::invokeMethod($locale, 'addLocaleAlias', [
            'fake.alias',
            'fake.undefined',
        ]);
    }

    /**
     * Test addLocaleCommon method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::addLocaleCommon
     */
    public function testAddLocaleCommon()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        // Add a fake common locale.
        static::invokeMethod($locale, 'addLocaleCommon', [
            'fake.locale',
            'integerSingular',
            'integerPlural',
            'decimalSingular',
            'decimalPlural',
        ]);

        $currency = $locale->getLocaleCallable('fake.locale');

        static::assertSame('integerSingular', call_user_func($currency, Count::SIDE_INTEGER, 1));
        static::assertSame('integerPlural', call_user_func($currency, Count::SIDE_INTEGER, 2));
        static::assertSame('decimalSingular', call_user_func($currency, Count::SIDE_DECIMAL, 1));
        static::assertSame('decimalPlural', call_user_func($currency, Count::SIDE_DECIMAL, 2));
    }

    /**
     * Test getLocalesOrdered method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::getLocalesOrdered
     */
    public function testGetLocalesOrdered()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        static::assertSame([ ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ null, null ]));

        static::assertSame([ 'pt' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt', null ]));
        static::assertSame([ 'pt-BR', 'pt' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', null ]));
        static::assertSame([ 'pt-BR', 'pt', 'en' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', [ 'en' ] ]));
        static::assertSame([ 'pt-BR', 'pt', 'en-US', 'en' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', [ 'en*US' ] ]));
        static::assertSame([ 'pt-BR', 'pt', 'en', 'es' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', [ 'en', 'es' ] ]));
        static::assertSame([ 'pt-BR', 'pt', 'en-US', 'en', 'es' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', [ 'en-US', 'es' ], ]));
        static::assertSame([ 'pt-BR', 'pt', 'en-US', 'en', 'es-ES', 'es' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', [ 'en-US', 'es ES' ], ]));

        static::assertSame([ 'pt' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt', [ 'pt' ] ]));
        static::assertSame([ 'pt-BR', 'pt' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt', [ 'pt-BR' ] ]));

        // Add a fake locale that will be set as default.
        static::invokeMethod($locale, 'addLocale', [
            'ar-AR',
            null,
        ]);

        static::assertSame([ 'pt', 'ar-AR', 'ar' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt', [ 'pt' ] ]));
        static::assertSame([ 'pt-BR', 'pt', 'ar-AR', 'ar' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt', [ 'pt-BR' ] ]));
        static::assertSame([ 'pt-BR', 'pt', 'en', 'ar-AR', 'ar' ],
            static::invokeMethod($locale, 'getLocalesOrdered', [ 'pt.BR', [ 'en' ] ]));
    }

    /**
     * Test getLocaleCallable method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::getLocaleCallable
     */
    public function testGetLocaleCallable()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        // Add a fake locale.
        static::invokeMethod($locale, 'addLocale', [
            'pt',
            function () {
                return 'ok';
            },
        ]);

        $localeCallable = $locale->getLocaleCallable('pt');

        static::assertInstanceOf(Closure::class, $localeCallable);
        static::assertSame('ok', call_user_func($localeCallable));
    }

    /**
     * Test getLocaleCallable method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::getLocaleCallable
     *
     * @expectedException \Rentalhost\VanillaCount\Exception\LocaleCallableUndefinedException
     */
    public function testLocaleCallableUndefinedException()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);
        $locale->getLocaleCallable('locale.undefined');
    }

    /**
     * Test getLocaleCallable method.
     *
     * @covers       \Rentalhost\VanillaCount\Currency\Currency::addLocale
     *
     * @expectedException \Rentalhost\VanillaCount\Exception\LocaleUndefinedException
     */
    public function testLocaleUndefinedExceptionOnAddLocale()
    {
        /** @var Currency $locale */
        $locale = static::getMockForAbstractClass(Currency::class);

        // Add a locale with invalid name.
        static::invokeMethod($locale, 'addLocale', [ '', null ]);
    }
}
