<?php

namespace Rentalhost\VanillaCount\Test;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Locale\EnglishLocale;

/**
 * Class EnglishLocaleTest
 * @package Rentalhost\VanillaCount
 */
class EnglishLocaleTest extends TestCase
{
    /**
     * Test number spelling.
     *
     * @param int    $number   Number to spelling.
     * @param string $expected Spelling expected.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::__construct
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::simple
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::format
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::formatType
     *
     * @dataProvider dataSpell
     */
    public function testSpell($number, $expected)
    {
        $count = new Count(new EnglishLocale);

        static::assertSame($expected, $count->spell($number));
    }

    /**
     * Data provider.
     */
    public function dataSpell()
    {
        return [
            [ 0, 'zero' ],
            [ 1, 'one' ],
            [ 2, 'two' ],
            [ 3, 'three' ],
            [ 4, 'four' ],
            [ 5, 'five' ],
            [ 6, 'six' ],
            [ 7, 'seven' ],
            [ 8, 'eight' ],
            [ 9, 'nine' ],

            [ 10, 'ten' ],
            [ 11, 'eleven' ],
            [ 12, 'twelve' ],
            [ 13, 'thirteen' ],
            [ 14, 'fourteen' ],
            [ 15, 'fifteen' ],
            [ 16, 'sixteen' ],
            [ 17, 'seventeen' ],
            [ 18, 'eighteen' ],
            [ 19, 'nineteen' ],

            [ 20, 'twenty' ],
            [ 21, 'twenty-one' ],

            [ 30, 'thirty' ],
            [ 40, 'fourty' ],
            [ 50, 'fifty' ],
            [ 60, 'sixty' ],
            [ 70, 'seventy' ],
            [ 80, 'eighty' ],
            [ 90, 'ninety' ],
            [ 100, 'one hundred' ],

            [ 101, 'one hundred and one' ],
            [ 110, 'one hundred and ten' ],
            [ 111, 'one hundred and eleven' ],
            [ 121, 'one hundred and twenty-one' ],

            [ 200, 'two hundred' ],
            [ 300, 'three hundred' ],
            [ 400, 'four hundred' ],
            [ 500, 'five hundred' ],
            [ 600, 'six hundred' ],
            [ 700, 'seven hundred' ],
            [ 800, 'eight hundred' ],
            [ 900, 'nine hundred' ],

            [ 1000, 'one thousand' ],
            [ 1001, 'one thousand and one' ],
            [ 1010, 'one thousand and ten' ],
            [ 1011, 'one thousand and eleven' ],
            [ 1021, 'one thousand and twenty-one' ],
            [ 1100, 'one thousand and one hundred' ],
            [ 1101, 'one thousand, one hundred and one' ],
            [ 1111, 'one thousand, one hundred and eleven' ],

            [ 2000, 'two thousand' ],
            [ 3000, 'three thousand' ],
            [ 4000, 'four thousand' ],
            [ 5000, 'five thousand' ],
            [ 6000, 'six thousand' ],
            [ 7000, 'seven thousand' ],
            [ 8000, 'eight thousand' ],
            [ 9000, 'nine thousand' ],

            [ 10000, 'ten thousand' ],
            [ 11111, 'eleven thousand, one hundred and eleven' ],

            [ 100100, 'one hundred thousand and one hundred' ],
            [ 100101, 'one hundred thousand, one hundred and one' ],

            [ 1000101, 'one million, one hundred and one' ],
            [ 1001100, 'one million, one thousand and one hundred' ],
            [ 1001112, 'one million, one thousand, one hundred and twelve' ],
            [ 1002000, 'one million and two thousand' ],
            [ 1101100, 'one million, one hundred and one thousand and one hundred' ],
            [ 1101101, 'one million, one hundred and one thousand, one hundred and one' ],

            [ 1000000, 'one million' ],
            [ 1000001, 'one million and one' ],
            [ 1000010, 'one million and ten' ],
            [ 1000100, 'one million and one hundred' ],
            [ 1001000, 'one million and one thousand' ],
            [ 1010000, 'one million and ten thousand' ],
            [ 1100000, 'one million and one hundred thousand' ],
            [ 1100001, 'one million, one hundred thousand and one' ],
            [ 1100010, 'one million, one hundred thousand and ten' ],
            [ 1100100, 'one million, one hundred thousand and one hundred' ],
            [ 1101000, 'one million and one hundred and one thousand' ],
            [ 1110000, 'one million and one hundred and ten thousand' ],
            [ 1110001, 'one million, one hundred and ten thousand and one' ],
            [ 1110010, 'one million, one hundred and ten thousand and ten' ],
            [ 1110100, 'one million, one hundred and ten thousand and one hundred' ],
            [ 1111000, 'one million and one hundred and eleven thousand' ],
            [ 1111001, 'one million, one hundred and eleven thousand and one' ],
            [ 1111010, 'one million, one hundred and eleven thousand and ten' ],
            [ 1111100, 'one million, one hundred and eleven thousand and one hundred' ],
            [ 1111101, 'one million, one hundred and eleven thousand, one hundred and one' ],
            [ 1111110, 'one million, one hundred and eleven thousand, one hundred and ten' ],
            [ 1111111, 'one million, one hundred and eleven thousand, one hundred and eleven' ],

            [ 2000000, 'two million' ],
            [ 2000002, 'two million and two' ],
            [ 2000020, 'two million and twenty' ],
            [ 2000200, 'two million and two hundred' ],
            [ 2002000, 'two million and two thousand' ],
            [ 2020000, 'two million and twenty thousand' ],
            [ 2200000, 'two million and two hundred thousand' ],
            [ 2200002, 'two million, two hundred thousand and two' ],
            [ 2200020, 'two million, two hundred thousand and twenty' ],
            [ 2200200, 'two million, two hundred thousand and two hundred' ],
            [ 2202000, 'two million and two hundred and two thousand' ],
            [ 2220000, 'two million and two hundred and twenty thousand' ],
            [ 2220002, 'two million, two hundred and twenty thousand and two' ],
            [ 2220020, 'two million, two hundred and twenty thousand and twenty' ],
            [ 2220200, 'two million, two hundred and twenty thousand and two hundred' ],
            [ 2222000, 'two million and two hundred and twenty-two thousand' ],
            [ 2222002, 'two million, two hundred and twenty-two thousand and two' ],
            [ 2222020, 'two million, two hundred and twenty-two thousand and twenty' ],
            [ 2222200, 'two million, two hundred and twenty-two thousand and two hundred' ],
            [ 2222202, 'two million, two hundred and twenty-two thousand, two hundred and two' ],
            [ 2222220, 'two million, two hundred and twenty-two thousand, two hundred and twenty' ],
            [ 2222222, 'two million, two hundred and twenty-two thousand, two hundred and twenty-two' ],

            [ 1000000000, 'one billion' ],
            [ 1000000001, 'one billion and one' ],
            [ 1000000010, 'one billion and ten' ],
            [ 1000000100, 'one billion and one hundred' ],
            [ 1000000111, 'one billion, one hundred and eleven' ],
            [ 1000001000, 'one billion and one thousand' ],
            [ 1000010000, 'one billion and ten thousand' ],
            [ 1000100000, 'one billion and one hundred thousand' ],
            [ 1001000000, 'one billion and one million' ],
            [ 1010000000, 'one billion and ten million' ],
            [ 1100000000, 'one billion and one hundred million' ],
            [ 1100000001, 'one billion, one hundred million and one' ],
            [ 1100000010, 'one billion, one hundred million and ten' ],
            [ 1100000100, 'one billion, one hundred million and one hundred' ],
            [ 1100001000, 'one billion, one hundred million and one thousand' ],
            [ 1100010000, 'one billion, one hundred million and ten thousand' ],
            [ 1100100000, 'one billion, one hundred million and one hundred thousand' ],
            [ 1101000000, 'one billion and one hundred and one million' ],
            [ 1110000000, 'one billion and one hundred and ten million' ],
            [ 1110000001, 'one billion, one hundred and ten million and one' ],
            [ 1110000010, 'one billion, one hundred and ten million and ten' ],
            [ 1110000100, 'one billion, one hundred and ten million and one hundred' ],
            [ 1110001000, 'one billion, one hundred and ten million and one thousand' ],
            [ 1110010000, 'one billion, one hundred and ten million and ten thousand' ],
            [ 1110100000, 'one billion, one hundred and ten million and one hundred thousand' ],
            [ 1111000000, 'one billion and one hundred and eleven million' ],
            [ 1111000001, 'one billion, one hundred and eleven million and one' ],
            [ 1111000010, 'one billion, one hundred and eleven million and ten' ],
            [ 1111000100, 'one billion, one hundred and eleven million and one hundred' ],
            [ 1111001000, 'one billion, one hundred and eleven million and one thousand' ],
            [ 1111010000, 'one billion, one hundred and eleven million and ten thousand' ],
            [ 1111100000, 'one billion, one hundred and eleven million and one hundred thousand' ],
            [ 1111100001, 'one billion, one hundred and eleven million, one hundred thousand and one' ],
            [ 1111100010, 'one billion, one hundred and eleven million, one hundred thousand and ten' ],
            [ 1111100100, 'one billion, one hundred and eleven million, one hundred thousand and one hundred' ],
            [ 1111101000, 'one billion, one hundred and eleven million and one hundred and one thousand' ],
            [ 1111110000, 'one billion, one hundred and eleven million and one hundred and ten thousand' ],
            [ 1111110001, 'one billion, one hundred and eleven million, one hundred and ten thousand and one' ],
            [ 1111110010, 'one billion, one hundred and eleven million, one hundred and ten thousand and ten' ],
            [ 1111110100, 'one billion, one hundred and eleven million, one hundred and ten thousand and one hundred' ],
            [ 1111111000, 'one billion, one hundred and eleven million and one hundred and eleven thousand' ],
            [ 1111111001, 'one billion, one hundred and eleven million, one hundred and eleven thousand and one' ],
            [ 1111111010, 'one billion, one hundred and eleven million, one hundred and eleven thousand and ten' ],
            [ 1111111100, 'one billion, one hundred and eleven million, one hundred and eleven thousand and one hundred' ],
            [ 1111111101, 'one billion, one hundred and eleven million, one hundred and eleven thousand, one hundred and one' ],
            [ 1111111110, 'one billion, one hundred and eleven million, one hundred and eleven thousand, one hundred and ten' ],
            [ 1111111111, 'one billion, one hundred and eleven million, one hundred and eleven thousand, one hundred and eleven' ],

            [ 2000000000, 'two billion' ],
            [ 2000000002, 'two billion and two' ],
            [ 2000000020, 'two billion and twenty' ],
            [ 2000000200, 'two billion and two hundred' ],
            [ 2000002000, 'two billion and two thousand' ],
            [ 2000020000, 'two billion and twenty thousand' ],
            [ 2000200000, 'two billion and two hundred thousand' ],
            [ 2002000000, 'two billion and two million' ],
            [ 2020000000, 'two billion and twenty million' ],
            [ 2200000000, 'two billion and two hundred million' ],
            [ 2200000002, 'two billion, two hundred million and two' ],
            [ 2200000020, 'two billion, two hundred million and twenty' ],
            [ 2200000200, 'two billion, two hundred million and two hundred' ],
            [ 2200002000, 'two billion, two hundred million and two thousand' ],
            [ 2200020000, 'two billion, two hundred million and twenty thousand' ],
            [ 2200200000, 'two billion, two hundred million and two hundred thousand' ],
            [ 2202000000, 'two billion and two hundred and two million' ],
            [ 2220000000, 'two billion and two hundred and twenty million' ],
            [ 2220000002, 'two billion, two hundred and twenty million and two' ],
            [ 2220000020, 'two billion, two hundred and twenty million and twenty' ],
            [ 2220000200, 'two billion, two hundred and twenty million and two hundred' ],
            [ 2220002000, 'two billion, two hundred and twenty million and two thousand' ],
            [ 2220020000, 'two billion, two hundred and twenty million and twenty thousand' ],
            [ 2220200000, 'two billion, two hundred and twenty million and two hundred thousand' ],
            [ 2222000000, 'two billion and two hundred and twenty-two million' ],
            [ 2222000002, 'two billion, two hundred and twenty-two million and two' ],
            [ 2222000020, 'two billion, two hundred and twenty-two million and twenty' ],
            [ 2222000200, 'two billion, two hundred and twenty-two million and two hundred' ],
            [ 2222002000, 'two billion, two hundred and twenty-two million and two thousand' ],
            [ 2222020000, 'two billion, two hundred and twenty-two million and twenty thousand' ],
            [ 2222200000, 'two billion, two hundred and twenty-two million and two hundred thousand' ],
            [ 2222200002, 'two billion, two hundred and twenty-two million, two hundred thousand and two' ],
            [ 2222200020, 'two billion, two hundred and twenty-two million, two hundred thousand and twenty' ],
            [ 2222200200, 'two billion, two hundred and twenty-two million, two hundred thousand and two hundred' ],
            [ 2222202000, 'two billion, two hundred and twenty-two million and two hundred and two thousand' ],
            [ 2222220000, 'two billion, two hundred and twenty-two million and two hundred and twenty thousand' ],
            [ 2222220002, 'two billion, two hundred and twenty-two million, two hundred and twenty thousand and two' ],
            [ 2222220020, 'two billion, two hundred and twenty-two million, two hundred and twenty thousand and twenty' ],
            [ 2222220200, 'two billion, two hundred and twenty-two million, two hundred and twenty thousand and two hundred' ],
            [ 2222222000, 'two billion, two hundred and twenty-two million and two hundred and twenty-two thousand' ],
            [ 2222222002, 'two billion, two hundred and twenty-two million, two hundred and twenty-two thousand and two' ],
            [ 2222222020, 'two billion, two hundred and twenty-two million, two hundred and twenty-two thousand and twenty' ],
            [ 2222222200, 'two billion, two hundred and twenty-two million, two hundred and twenty-two thousand and two hundred' ],
            [
                2222222202,
                'two billion, two hundred and twenty-two million, two hundred and twenty-two thousand, two hundred and two',
            ],
            [
                2222222220,
                'two billion, two hundred and twenty-two million, two hundred and twenty-two thousand, two hundred and twenty',
            ],
            [
                2222222222,
                'two billion, two hundred and twenty-two million, two hundred and twenty-two thousand, two hundred and twenty-two',
            ],

            [
                123456789,
                'one hundred and twenty-three million, four hundred and fifty-six thousand, seven hundred and eighty-nine',
            ],
            [
                987654321,
                'nine hundred and eighty-seven million, six hundred and fifty-four thousand, three hundred and twenty-one',
            ],

            [
                '1001001001001001001001001001001001',
                'one decillion, one nonillion, one octillion, one septillion, one sextillion, one quintillion, one quadrillion, one trillion, ' .
                'one billion, one million, one thousand and one',
            ],
        ];
    }

    /**
     * Test number spelling with options.
     *
     * @param array  $options  Options to spelling.
     * @param int    $number   Number to spelling.
     * @param string $expected Spelling expected.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::__construct
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::simple
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::format
     *
     * @dataProvider dataSpellWithOptions
     */
    public function testSpellWithOptions($options, $number, $expected)
    {
        $count = new Count(new EnglishLocale($options));

        static::assertSame($expected, $count->spell($number));
    }

    /**
     * Data provider.
     */
    public function dataSpellWithOptions()
    {
        return [
            [ [ 'simpleSpells' => [ 1 => 'ONE' ] ], 100, 'ONE hundred' ],
            [ [ 'highSpells' => [ 'THOUSAND' ] ], 1000, 'one THOUSAND' ],
            [ [ 'zeroSpell' => 'ZERO' ], 0, 'ZERO' ],

            [ [ 'hundredSpell' => ' HUNDRED' ], 100, 'one HUNDRED' ],
            [ [ 'hundredSeparator' => '-' ], 101, 'one hundred-one' ],

            [ [ 'firstOneIdentifier' => 'a' ], 1, 'one' ],
            [ [ 'firstOneIdentifier' => 'a' ], 100, 'a hundred' ],
            [ [ 'firstOneIdentifier' => null ], 100, 'hundred' ],

            [ [ 'firstOneIdentifier' => 'a' ], 1000, 'a thousand' ],
            [ [ 'firstOneIdentifier' => null ], 1000, 'thousand' ],

            [ [ 'compoundSeparator' => '~' ], 21, 'twenty~one' ],
            [ [ 'defaultSeparator' => null ], 1001001, 'one million one thousand and one' ],
            [ [ 'lastSeparator' => null ], 1001, 'one thousand one' ],
        ];
    }

    /**
     * Test number spelling with options.
     *
     * @param array  $options  Options to spelling.
     * @param int    $number   Number to spelling.
     * @param string $expected Spelling expected.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::format
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::formatType
     * @covers       \Rentalhost\VanillaCount\Locale\EnglishLocale::formatType
     *
     * @dataProvider dataSpellCurrency
     */
    public function testSpellCurrency($options, $number, $expected)
    {
        $count = new Count(new EnglishLocale($options));

        static::assertSame($expected, $count->spell($number, Count::SPELLING_CURRENCY));
    }

    /**
     * Data provider.
     */
    public function dataSpellCurrency()
    {
        return [
            [ null, 0, 'zero dollar' ],
            [ null, 1, 'one dollar' ],
            [ null, 2, 'two dollars' ],
            [ null, 1000, 'one thousand dollars' ],
            [ null, 1001, 'one thousand and one dollars' ],
            [ null, 1002, 'one thousand and two dollars' ],
            [ null, 1000000, 'one million dollars' ],
            [ null, 2000000, 'two million dollars' ],
            [ null, 1001001, 'one million, one thousand and one dollars' ],
            [ null, 1002000000, 'one billion and two million dollars' ],

            [ null, 1000, 'one thousand dollars' ],
            [ null, 1001, 'one thousand and one dollars' ],
            [ null, 1010, 'one thousand and ten dollars' ],
            [ null, 1011, 'one thousand and eleven dollars' ],
            [ null, 1021, 'one thousand and twenty-one dollars' ],
            [ null, 1100, 'one thousand and one hundred dollars' ],
            [ null, 1101, 'one thousand, one hundred and one dollars' ],
            [ null, 1111, 'one thousand, one hundred and eleven dollars' ],

            [ null, 2000, 'two thousand dollars' ],
            [ null, 3000, 'three thousand dollars' ],
            [ null, 4000, 'four thousand dollars' ],
            [ null, 5000, 'five thousand dollars' ],
            [ null, 6000, 'six thousand dollars' ],
            [ null, 7000, 'seven thousand dollars' ],
            [ null, 8000, 'eight thousand dollars' ],
            [ null, 9000, 'nine thousand dollars' ],

            [ null, 0.01, 'one cent' ],
            [ null, 0.15, 'fifteen cents' ],

            [ null, 0.00, 'zero dollar' ],
            [ null, 1.00, 'one dollar' ],
            [ null, 2.00, 'two dollars' ],
            [ null, 2.01, 'two dollars and one cent' ],
            [ null, 2.50, 'two dollars and fifty cents' ],

            [ null, 1000.01, 'one thousand dollars and one cent' ],
            [ null, 1101.01, 'one thousand, one hundred and one dollars and one cent' ],
            [ null, 1000000.01, 'one million dollars and one cent' ],
            [ null, 1001001.01, 'one million, one thousand and one dollars and one cent' ],

            [ null, 2000.02, 'two thousand dollars and two cents' ],
            [ null, 2000000.02, 'two million dollars and two cents' ],
            [ null, 2002002.02, 'two million, two thousand and two dollars and two cents' ],

            [ [ 'currency' => 'real' ], 0, 'zero real' ],
            [ [ 'currency' => 'real' ], 1, 'one real' ],
            [ [ 'currency' => 'real' ], 2, 'two reais' ],
            [ [ 'currency' => 'real' ], 1000, 'one thousand reais' ],
            [ [ 'currency' => 'real' ], 1001, 'one thousand and one reais' ],
            [ [ 'currency' => 'real' ], 1002, 'one thousand and two reais' ],
            [ [ 'currency' => 'real' ], 1000000, 'one million reais' ],
            [ [ 'currency' => 'real' ], 2000000, 'two million reais' ],
            [ [ 'currency' => 'real' ], 1001001, 'one million, one thousand and one reais' ],
            [ [ 'currency' => 'real' ], 1001001, 'one million, one thousand and one reais' ],
            [ [ 'currency' => 'real' ], 1002000000, 'one billion and two million reais' ],

            [ [ 'currency' => 'real' ], 1000, 'one thousand reais' ],
            [ [ 'currency' => 'real' ], 1001, 'one thousand and one reais' ],
            [ [ 'currency' => 'real' ], 1010, 'one thousand and ten reais' ],
            [ [ 'currency' => 'real' ], 1011, 'one thousand and eleven reais' ],
            [ [ 'currency' => 'real' ], 1021, 'one thousand and twenty-one reais' ],
            [ [ 'currency' => 'real' ], 1100, 'one thousand and one hundred reais' ],
            [ [ 'currency' => 'real' ], 1101, 'one thousand, one hundred and one reais' ],
            [ [ 'currency' => 'real' ], 1111, 'one thousand, one hundred and eleven reais' ],

            [ [ 'currency' => 'real' ], 2000, 'two thousand reais' ],
            [ [ 'currency' => 'real' ], 3000, 'three thousand reais' ],
            [ [ 'currency' => 'real' ], 4000, 'four thousand reais' ],
            [ [ 'currency' => 'real' ], 5000, 'five thousand reais' ],
            [ [ 'currency' => 'real' ], 6000, 'six thousand reais' ],
            [ [ 'currency' => 'real' ], 7000, 'seven thousand reais' ],
            [ [ 'currency' => 'real' ], 8000, 'eight thousand reais' ],
            [ [ 'currency' => 'real' ], 9000, 'nine thousand reais' ],

            [ [ 'currency' => 'real' ], 0.01, 'one cent' ],
            [ [ 'currency' => 'real' ], 0.15, 'fifteen cents' ],

            [ [ 'currency' => 'real' ], 0.00, 'zero real' ],
            [ [ 'currency' => 'real' ], 1.00, 'one real' ],
            [ [ 'currency' => 'real' ], 2.00, 'two reais' ],
            [ [ 'currency' => 'real' ], 2.01, 'two reais and one cent' ],
            [ [ 'currency' => 'real' ], 2.50, 'two reais and fifty cents' ],

            [ [ 'currency' => 'real' ], 1000.01, 'one thousand reais and one cent' ],
            [ [ 'currency' => 'real' ], 1101.01, 'one thousand, one hundred and one reais and one cent' ],
            [ [ 'currency' => 'real' ], 1000000.01, 'one million reais and one cent' ],
            [ [ 'currency' => 'real' ], 1001001.01, 'one million, one thousand and one reais and one cent' ],

            [ [ 'currency' => 'real' ], 2000.02, 'two thousand reais and two cents' ],
            [ [ 'currency' => 'real' ], 2000000.02, 'two million reais and two cents' ],
            [ [ 'currency' => 'real' ], 2002002.02, 'two million, two thousand and two reais and two cents' ],

            [ [ 'currency' => 'real', 'currencyLocale' => 'pt' ], 2000.02, 'two thousand reais and two centavos' ],
            [ [ 'currency' => 'real', 'currencyLocale' => 'pt' ], 2000000.02, 'two million reais and two centavos' ],
            [ [ 'currency' => 'real', 'currencyLocale' => 'pt' ], 2002002.02, 'two million, two thousand and two reais and two centavos', ],

            [ [ 'currencySeparator' => ' of ' ], 1000000, 'one million of dollars' ],
            [ [ 'currencyDecimalSeparator' => ' more ' ], 1000.02, 'one thousand dollars more two cents' ],

            [ [ 'currency' => 'real', 'currencyLocale' => null ], 1, 'one real' ],
            [ [ 'currency' => 'real', 'currencyLocale' => null ], 2, 'two reais' ],
            [ [ 'currency' => 'real', 'currencyLocale' => null ], 1000, 'one thousand reais' ],
        ];
    }
}
