<?php

namespace Rentalhost\VanillaCount\Test;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Locale\Locale;
use Rentalhost\VanillaCount\Locale\PortugueseLocale;

/**
 * Class CountTest
 * @package Rentalhost\VanillaCount\Test
 */
class CountTest extends TestCase
{
    /**
     * Test __construct method.
     *
     * @covers       \Rentalhost\VanillaCount\Count::__construct
     */
    public function testConstruct()
    {
        // Load from instance.
        $count = new Count(new PortugueseLocale());

        static::assertInstanceOf(PortugueseLocale::class, static::readAttribute($count, 'locale'));

        // Load from instance, rewriting options.
        $count       = new Count(new PortugueseLocale([ 'option' => 'original' ]), [ 'option' => 'rewrited' ]);
        $countLocale = static::readAttribute($count, 'locale');

        static::assertSame('rewrited', static::readAttribute($countLocale, 'options')->option);

        // Load from string.
        $count = new Count('portuguese');

        static::assertInstanceOf(PortugueseLocale::class, static::readAttribute($count, 'locale'));

        // Load from string, with options.
        $count       = new Count('portuguese', [ 'option' => 'value' ]);
        $countLocale = static::readAttribute($count, 'locale');

        static::assertSame('value', static::readAttribute($countLocale, 'options')->option);
    }

    /**
     * Test normalizeNumber method.
     *
     * @param string     $expected    Normalized number.
     * @param string|int $number      Number to normalize.
     * @param int        $paddingType Number padding type
     *
     * @covers       \Rentalhost\VanillaCount\Count::normalizeNumber
     *
     * @dataProvider dataNormalizeNumber
     */
    public function testNormalizeNumber($expected, $number, $paddingType = STR_PAD_LEFT)
    {
        /** @var Locale $locale */
        $locale = static::getMockForAbstractClass(Locale::class);
        $count  = new Count($locale);

        static::assertSame($expected, static::invokeMethod($count, 'normalizeNumber', [ $number, $paddingType ]));
    }

    /**
     * Data provider.
     */
    public function dataNormalizeNumber()
    {
        return [
            // One land number.
            [ '000', 0 ],
            [ '015', 15 ],
            [ '150', 15, STR_PAD_RIGHT ],

            // More land number.
            [ '001000', 1000 ],
            [ '001500', 1500 ],
            [ '150000', 1500, STR_PAD_RIGHT ],

            // Long number.
            [ '011222333444555666777888999000', '11222333444555666777888999000' ],
            [ '112223334445556667778889990000', '11222333444555666777888999000', STR_PAD_RIGHT ],
        ];
    }

    /**
     * Test getNumberLands method.
     *
     * @param string|int $number   Number to convert.
     * @param int[]      $expected Number converted.
     *
     * @covers       \Rentalhost\VanillaCount\Count::getNumberLands
     *
     * @dataProvider dataGetNumberLands
     */
    public function testGetNumberLands($number, $expected)
    {
        /** @var Locale $locale */
        $locale = static::getMockForAbstractClass(Locale::class);
        $count  = new Count($locale);

        static::assertSame($expected, static::invokeMethod($count, 'getNumberLands', [ $number ]));
    }

    /**
     * Data provider.
     */
    public function dataGetNumberLands()
    {
        return [
            // One land number.
            [ 0, [ 0 ] ],
            [ 15, [ 15 ] ],

            // More land number.
            [ 1000, [ 0, 1 ] ],
            [ 1500, [ 500, 1 ] ],

            // With decimals.
            [ '1500.00', [ -1 => 0, 500, 1 ] ],
            [ 1500.00, [ 500, 1 ] ],
            [ 1500.01, [ -1 => 10, 500, 1 ] ],
            [ 1500.1, [ -1 => 100, 500, 1 ] ],
            [ 1500.10, [ -1 => 100, 500, 1 ] ],
            [ 1500.105, [ -1 => 105, 500, 1 ] ],
            [ 1500.105500, [ -2 => 500, -1 => 105, 500, 1 ] ],
            [ 1500.000500, [ -2 => 500, -1 => 0, 500, 1 ] ],
            [ 1500.0005001, [ -3 => 100, -2 => 500, -1 => 0, 500, 1 ] ],
            [ '1 500.0 0 0 5 0 0 1', [ -3 => 100, -2 => 500, -1 => 0, 500, 1 ] ],

            // Long number.
            [ '11222333444555666777888999000', [ 0, 999, 888, 777, 666, 555, 444, 333, 222, 11 ] ],
        ];
    }

    /**
     * Test spell method.
     *
     * @covers       \Rentalhost\VanillaCount\Count::__construct
     * @covers       \Rentalhost\VanillaCount\Count::spell
     */
    public function testSpell()
    {
        $count = new Count(new PortugueseLocale());

        static::assertSame('zero', $count->spell(0));
        static::assertSame('um', $count->spell(1));
    }
}
