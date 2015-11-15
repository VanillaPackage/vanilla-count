<?php

namespace Rentalhost\VanillaCount\Test;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Locale\Locale;
use Rentalhost\VanillaCount\Locale\PortugueseLocale;

/**
 * Class PortugueseLocaleTest
 * @package Rentalhost\VanillaCount
 */
class PortugueseLocaleTest extends TestCase
{
    /**
     * Test number spelling.
     *
     * @param int    $number   Number to spelling.
     * @param string $expected Spelling expected.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::__construct
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::simple
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::format
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::formatType
     *
     * @dataProvider dataSpell
     */
    public function testSpell($number, $expected)
    {
        $count = new Count(new PortugueseLocale);

        static::assertSame($expected, $count->spell($number));
    }

    /**
     * Data provider.
     */
    public function dataSpell()
    {
        return [
            [ 0, 'zero' ],
            [ 1, 'um' ],
            [ 2, 'dois' ],
            [ 3, 'três' ],
            [ 4, 'quatro' ],
            [ 5, 'cinco' ],
            [ 6, 'seis' ],
            [ 7, 'sete' ],
            [ 8, 'oito' ],
            [ 9, 'nove' ],

            [ 10, 'dez' ],
            [ 11, 'onze' ],
            [ 12, 'doze' ],
            [ 13, 'treze' ],
            [ 14, 'quatorze' ],
            [ 15, 'quinze' ],
            [ 16, 'dezesseis' ],
            [ 17, 'dezessete' ],
            [ 18, 'dezoito' ],
            [ 19, 'dezenove' ],

            [ 20, 'vinte' ],
            [ 21, 'vinte e um' ],

            [ 30, 'trinta' ],
            [ 40, 'quarenta' ],
            [ 50, 'cinquenta' ],
            [ 60, 'sessenta' ],
            [ 70, 'setenta' ],
            [ 80, 'oitenta' ],
            [ 90, 'noventa' ],
            [ 100, 'cem' ],

            [ 101, 'cento e um' ],
            [ 110, 'cento e dez' ],
            [ 111, 'cento e onze' ],
            [ 121, 'cento e vinte e um' ],

            [ 200, 'duzentos' ],
            [ 300, 'trezentos' ],
            [ 400, 'quatrocentos' ],
            [ 500, 'quinhentos' ],
            [ 600, 'seiscentos' ],
            [ 700, 'setecentos' ],
            [ 800, 'oitocentos' ],
            [ 900, 'novecentos' ],

            [ 1000, 'mil' ],
            [ 1001, 'mil e um' ],
            [ 1010, 'mil e dez' ],
            [ 1011, 'mil e onze' ],
            [ 1021, 'mil e vinte e um' ],
            [ 1100, 'mil e cem' ],
            [ 1101, 'mil, cento e um' ],
            [ 1111, 'mil, cento e onze' ],

            [ 2000, 'dois mil' ],
            [ 3000, 'três mil' ],
            [ 4000, 'quatro mil' ],
            [ 5000, 'cinco mil' ],
            [ 6000, 'seis mil' ],
            [ 7000, 'sete mil' ],
            [ 8000, 'oito mil' ],
            [ 9000, 'nove mil' ],

            [ 10000, 'dez mil' ],
            [ 11111, 'onze mil, cento e onze' ],

            [ 100100, 'cem mil e cem' ],
            [ 100101, 'cem mil, cento e um' ],

            [ 1000001, 'um milhão e um' ],
            [ 1000100, 'um milhão e cem' ],
            [ 1000101, 'um milhão, cento e um' ],
            [ 1001000, 'um milhão e mil' ],
            [ 1001100, 'um milhão, mil e cem' ],
            [ 1001112, 'um milhão, mil, cento e doze' ],
            [ 1002000, 'um milhão e dois mil' ],
            [ 1100000, 'um milhão e cem mil' ],
            [ 1100100, 'um milhão, cem mil e cem' ],
            [ 1101000, 'um milhão e cento e um mil' ],
            [ 1101100, 'um milhão, cento e um mil e cem' ],
            [ 1101101, 'um milhão, cento e um mil, cento e um' ],

            [ 1000000, 'um milhão' ],
            [ 1000001, 'um milhão e um' ],
            [ 1000010, 'um milhão e dez' ],
            [ 1000100, 'um milhão e cem' ],
            [ 1001000, 'um milhão e mil' ],
            [ 1010000, 'um milhão e dez mil' ],
            [ 1100000, 'um milhão e cem mil' ],
            [ 1100001, 'um milhão, cem mil e um' ],
            [ 1100010, 'um milhão, cem mil e dez' ],
            [ 1100100, 'um milhão, cem mil e cem' ],
            [ 1101000, 'um milhão e cento e um mil' ],
            [ 1110000, 'um milhão e cento e dez mil' ],
            [ 1110001, 'um milhão, cento e dez mil e um' ],
            [ 1110010, 'um milhão, cento e dez mil e dez' ],
            [ 1110100, 'um milhão, cento e dez mil e cem' ],
            [ 1111000, 'um milhão e cento e onze mil' ],
            [ 1111001, 'um milhão, cento e onze mil e um' ],
            [ 1111010, 'um milhão, cento e onze mil e dez' ],
            [ 1111100, 'um milhão, cento e onze mil e cem' ],
            [ 1111101, 'um milhão, cento e onze mil, cento e um' ],
            [ 1111110, 'um milhão, cento e onze mil, cento e dez' ],
            [ 1111111, 'um milhão, cento e onze mil, cento e onze' ],

            [ 2000000, 'dois milhões' ],
            [ 2000002, 'dois milhões e dois' ],
            [ 2000020, 'dois milhões e vinte' ],
            [ 2000200, 'dois milhões e duzentos' ],
            [ 2002000, 'dois milhões e dois mil' ],
            [ 2020000, 'dois milhões e vinte mil' ],
            [ 2200000, 'dois milhões e duzentos mil' ],
            [ 2200002, 'dois milhões, duzentos mil e dois' ],
            [ 2200020, 'dois milhões, duzentos mil e vinte' ],
            [ 2200200, 'dois milhões, duzentos mil e duzentos' ],
            [ 2202000, 'dois milhões e duzentos e dois mil' ],
            [ 2220000, 'dois milhões e duzentos e vinte mil' ],
            [ 2220002, 'dois milhões, duzentos e vinte mil e dois' ],
            [ 2220020, 'dois milhões, duzentos e vinte mil e vinte' ],
            [ 2220200, 'dois milhões, duzentos e vinte mil e duzentos' ],
            [ 2222000, 'dois milhões e duzentos e vinte e dois mil' ],
            [ 2222002, 'dois milhões, duzentos e vinte e dois mil e dois' ],
            [ 2222020, 'dois milhões, duzentos e vinte e dois mil e vinte' ],
            [ 2222200, 'dois milhões, duzentos e vinte e dois mil e duzentos' ],
            [ 2222202, 'dois milhões, duzentos e vinte e dois mil, duzentos e dois' ],
            [ 2222220, 'dois milhões, duzentos e vinte e dois mil, duzentos e vinte' ],
            [ 2222222, 'dois milhões, duzentos e vinte e dois mil, duzentos e vinte e dois' ],

            [ 1000000000, 'um bilhão' ],
            [ 1000000001, 'um bilhão e um' ],
            [ 1000000010, 'um bilhão e dez' ],
            [ 1000000100, 'um bilhão e cem' ],
            [ 1000000111, 'um bilhão, cento e onze' ],
            [ 1000001000, 'um bilhão e mil' ],
            [ 1000010000, 'um bilhão e dez mil' ],
            [ 1000100000, 'um bilhão e cem mil' ],
            [ 1001000000, 'um bilhão e um milhão' ],
            [ 1010000000, 'um bilhão e dez milhões' ],
            [ 1100000000, 'um bilhão e cem milhões' ],
            [ 1100000001, 'um bilhão, cem milhões e um' ],
            [ 1100000010, 'um bilhão, cem milhões e dez' ],
            [ 1100000100, 'um bilhão, cem milhões e cem' ],
            [ 1100001000, 'um bilhão, cem milhões e mil' ],
            [ 1100010000, 'um bilhão, cem milhões e dez mil' ],
            [ 1100100000, 'um bilhão, cem milhões e cem mil' ],
            [ 1101000000, 'um bilhão e cento e um milhões' ],
            [ 1110000000, 'um bilhão e cento e dez milhões' ],
            [ 1110000001, 'um bilhão, cento e dez milhões e um' ],
            [ 1110000010, 'um bilhão, cento e dez milhões e dez' ],
            [ 1110000100, 'um bilhão, cento e dez milhões e cem' ],
            [ 1110001000, 'um bilhão, cento e dez milhões e mil' ],
            [ 1110010000, 'um bilhão, cento e dez milhões e dez mil' ],
            [ 1110100000, 'um bilhão, cento e dez milhões e cem mil' ],
            [ 1111000000, 'um bilhão e cento e onze milhões' ],
            [ 1111000001, 'um bilhão, cento e onze milhões e um' ],
            [ 1111000010, 'um bilhão, cento e onze milhões e dez' ],
            [ 1111000100, 'um bilhão, cento e onze milhões e cem' ],
            [ 1111001000, 'um bilhão, cento e onze milhões e mil' ],
            [ 1111010000, 'um bilhão, cento e onze milhões e dez mil' ],
            [ 1111100000, 'um bilhão, cento e onze milhões e cem mil' ],
            [ 1111100001, 'um bilhão, cento e onze milhões, cem mil e um' ],
            [ 1111100010, 'um bilhão, cento e onze milhões, cem mil e dez' ],
            [ 1111100100, 'um bilhão, cento e onze milhões, cem mil e cem' ],
            [ 1111101000, 'um bilhão, cento e onze milhões e cento e um mil' ],
            [ 1111110000, 'um bilhão, cento e onze milhões e cento e dez mil' ],
            [ 1111110001, 'um bilhão, cento e onze milhões, cento e dez mil e um' ],
            [ 1111110010, 'um bilhão, cento e onze milhões, cento e dez mil e dez' ],
            [ 1111110100, 'um bilhão, cento e onze milhões, cento e dez mil e cem' ],
            [ 1111111000, 'um bilhão, cento e onze milhões e cento e onze mil' ],
            [ 1111111001, 'um bilhão, cento e onze milhões, cento e onze mil e um' ],
            [ 1111111010, 'um bilhão, cento e onze milhões, cento e onze mil e dez' ],
            [ 1111111100, 'um bilhão, cento e onze milhões, cento e onze mil e cem' ],
            [ 1111111101, 'um bilhão, cento e onze milhões, cento e onze mil, cento e um' ],
            [ 1111111110, 'um bilhão, cento e onze milhões, cento e onze mil, cento e dez' ],
            [ 1111111111, 'um bilhão, cento e onze milhões, cento e onze mil, cento e onze' ],

            [ 2000000000, 'dois bilhões' ],
            [ 2000000002, 'dois bilhões e dois' ],
            [ 2000000020, 'dois bilhões e vinte' ],
            [ 2000000200, 'dois bilhões e duzentos' ],
            [ 2000002000, 'dois bilhões e dois mil' ],
            [ 2000020000, 'dois bilhões e vinte mil' ],
            [ 2000200000, 'dois bilhões e duzentos mil' ],
            [ 2002000000, 'dois bilhões e dois milhões' ],
            [ 2020000000, 'dois bilhões e vinte milhões' ],
            [ 2200000000, 'dois bilhões e duzentos milhões' ],
            [ 2200000002, 'dois bilhões, duzentos milhões e dois' ],
            [ 2200000020, 'dois bilhões, duzentos milhões e vinte' ],
            [ 2200000200, 'dois bilhões, duzentos milhões e duzentos' ],
            [ 2200002000, 'dois bilhões, duzentos milhões e dois mil' ],
            [ 2200020000, 'dois bilhões, duzentos milhões e vinte mil' ],
            [ 2200200000, 'dois bilhões, duzentos milhões e duzentos mil' ],
            [ 2202000000, 'dois bilhões e duzentos e dois milhões' ],
            [ 2220000000, 'dois bilhões e duzentos e vinte milhões' ],
            [ 2220000002, 'dois bilhões, duzentos e vinte milhões e dois' ],
            [ 2220000020, 'dois bilhões, duzentos e vinte milhões e vinte' ],
            [ 2220000200, 'dois bilhões, duzentos e vinte milhões e duzentos' ],
            [ 2220002000, 'dois bilhões, duzentos e vinte milhões e dois mil' ],
            [ 2220020000, 'dois bilhões, duzentos e vinte milhões e vinte mil' ],
            [ 2220200000, 'dois bilhões, duzentos e vinte milhões e duzentos mil' ],
            [ 2222000000, 'dois bilhões e duzentos e vinte e dois milhões' ],
            [ 2222000002, 'dois bilhões, duzentos e vinte e dois milhões e dois' ],
            [ 2222000020, 'dois bilhões, duzentos e vinte e dois milhões e vinte' ],
            [ 2222000200, 'dois bilhões, duzentos e vinte e dois milhões e duzentos' ],
            [ 2222002000, 'dois bilhões, duzentos e vinte e dois milhões e dois mil' ],
            [ 2222020000, 'dois bilhões, duzentos e vinte e dois milhões e vinte mil' ],
            [ 2222200000, 'dois bilhões, duzentos e vinte e dois milhões e duzentos mil' ],
            [ 2222200002, 'dois bilhões, duzentos e vinte e dois milhões, duzentos mil e dois' ],
            [ 2222200020, 'dois bilhões, duzentos e vinte e dois milhões, duzentos mil e vinte' ],
            [ 2222200200, 'dois bilhões, duzentos e vinte e dois milhões, duzentos mil e duzentos' ],
            [ 2222202000, 'dois bilhões, duzentos e vinte e dois milhões e duzentos e dois mil' ],
            [ 2222220000, 'dois bilhões, duzentos e vinte e dois milhões e duzentos e vinte mil' ],
            [ 2222220002, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte mil e dois' ],
            [ 2222220020, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte mil e vinte' ],
            [ 2222220200, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte mil e duzentos' ],
            [ 2222222000, 'dois bilhões, duzentos e vinte e dois milhões e duzentos e vinte e dois mil' ],
            [ 2222222002, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte e dois mil e dois' ],
            [ 2222222020, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte e dois mil e vinte' ],
            [ 2222222200, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte e dois mil e duzentos' ],
            [ 2222222202, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte e dois mil, duzentos e dois' ],
            [ 2222222220, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte e dois mil, duzentos e vinte' ],
            [ 2222222222, 'dois bilhões, duzentos e vinte e dois milhões, duzentos e vinte e dois mil, duzentos e vinte e dois' ],

            [ 123456789, 'cento e vinte e três milhões, quatrocentos e cinquenta e seis mil, setecentos e oitenta e nove' ],
            [ 987654321, 'novecentos e oitenta e sete milhões, seiscentos e cinquenta e quatro mil, trezentos e vinte e um' ],

            [
                '1001001001001001001001001001001001',
                'um decilhão, um nonilhão, um octilhão, um septilhão, um sextilhão, um quintilhão, um quatrilhão, um trilhão, ' .
                'um bilhão, um milhão, mil e um',
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
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::__construct
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::simple
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::format
     *
     * @dataProvider dataSpellWithOptions
     */
    public function testSpellWithOptions($options, $number, $expected)
    {
        $count = new Count(new PortugueseLocale($options));

        static::assertSame($expected, $count->spell($number));
    }

    /**
     * Data provider.
     */
    public function dataSpellWithOptions()
    {
        return [
            [ [ 'gender' => Locale::GENDER_FEMALE ], 0, 'zero' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1, 'uma' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 2, 'duas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 3, 'três' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 4, 'quatro' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 5, 'cinco' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 6, 'seis' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 7, 'sete' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 8, 'oito' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 9, 'nove' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 10, 'dez' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 11, 'onze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 12, 'doze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 13, 'treze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 14, 'quatorze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 15, 'quinze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 16, 'dezesseis' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 17, 'dezessete' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 18, 'dezoito' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 19, 'dezenove' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 20, 'vinte' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 21, 'vinte e uma' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 30, 'trinta' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 40, 'quarenta' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 50, 'cinquenta' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 60, 'sessenta' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 70, 'setenta' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 80, 'oitenta' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 90, 'noventa' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 100, 'cem' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 101, 'cento e uma' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 110, 'cento e dez' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 111, 'cento e onze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 121, 'cento e vinte e uma' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 200, 'duzentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 300, 'trezentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 400, 'quatrocentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 500, 'quinhentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 600, 'seiscentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 700, 'setecentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 800, 'oitocentas' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 900, 'novecentas' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 1000, 'mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1001, 'mil e uma' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1010, 'mil e dez' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1011, 'mil e onze' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1021, 'mil e vinte e uma' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1100, 'mil e cem' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1101, 'mil, cento e uma' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 1111, 'mil, cento e onze' ],

            [ [ 'gender' => Locale::GENDER_FEMALE ], 2000, 'duas mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 3000, 'três mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 4000, 'quatro mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 5000, 'cinco mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 6000, 'seis mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 7000, 'sete mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 8000, 'oito mil' ],
            [ [ 'gender' => Locale::GENDER_FEMALE ], 9000, 'nove mil' ],

            [ [ 'simpleSpells' => [ 1 => 'one' ] ], 1, 'one' ],
            [ [ 'simpleSpells' => [ ] ], 2, 'zero' ],

            [
                [
                    'simpleSpellsFemale' => [ 1 => 'UMA' ],
                    'gender'             => Locale::GENDER_FEMALE,
                ],
                1001,
                'mil e UMA',
            ],

            [
                [
                    'millionRoots'    => [ 'MILH' ],
                    'millionSuffixes' => [ 'ÃO', 'ÕES' ],
                ],
                1000000,
                'um MILHÃO',
            ],

            [ [ 'zeroSpell' => 'nenhum' ], 0, 'nenhum' ],
            [ [ 'hundredSpell' => 'CEM' ], 100, 'CEM' ],
            [ [ 'thousandSpell' => 'MIL' ], 1000, 'MIL' ],

            [ [ 'defaultSeparator' => null ], 1001001, 'um milhão mil e um' ],

            [ [ 'lastSeparator' => ' and ' ], 1001001, 'um milhão, mil and um' ],
            [ [ 'lastSeparator' => null ], 1001001, 'um milhão, mil um' ],

            [ [ 'includeOneThousand' => true ], 1001001, 'um milhão, um mil e um' ],
        ];
    }

    /**
     * Test number spelling with options.
     *
     * @param array  $options  Options to spelling.
     * @param int    $number   Number to spelling.
     * @param string $expected Spelling expected.
     *
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::format
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::formatType
     * @covers       \Rentalhost\VanillaCount\Locale\PortugueseLocale::formatType
     *
     * @dataProvider dataSpellCurrency
     */
    public function testSpellCurrency($options, $number, $expected)
    {
        $count = new Count(new PortugueseLocale($options));

        static::assertSame($expected, $count->spell($number, Count::SPELLING_CURRENCY));
    }

    /**
     * Data provider.
     */
    public function dataSpellCurrency()
    {
        return [
            [ null, 0, 'zero real' ],
            [ null, 1, 'um real' ],
            [ null, 2, 'dois reais' ],
            [ null, 1000, 'mil reais' ],
            [ null, 1001, 'mil e um reais' ],
            [ null, 1002, 'mil e dois reais' ],
            [ null, 1000000, 'um milhão de reais' ],
            [ null, 2000000, 'dois milhões de reais' ],
            [ null, 1001001, 'um milhão, mil e um reais' ],
            [ null, 1002000000, 'um bilhão e dois milhões de reais' ],

            [ null, 1000, 'mil reais' ],
            [ null, 1001, 'mil e um reais' ],
            [ null, 1010, 'mil e dez reais' ],
            [ null, 1011, 'mil e onze reais' ],
            [ null, 1021, 'mil e vinte e um reais' ],
            [ null, 1100, 'mil e cem reais' ],
            [ null, 1101, 'mil, cento e um reais' ],
            [ null, 1111, 'mil, cento e onze reais' ],

            [ null, 2000, 'dois mil reais' ],
            [ null, 3000, 'três mil reais' ],
            [ null, 4000, 'quatro mil reais' ],
            [ null, 5000, 'cinco mil reais' ],
            [ null, 6000, 'seis mil reais' ],
            [ null, 7000, 'sete mil reais' ],
            [ null, 8000, 'oito mil reais' ],
            [ null, 9000, 'nove mil reais' ],

            [ null, 0.01, 'um centavo' ],
            [ null, 0.15, 'quinze centavos' ],

            [ null, 0.00, 'zero real' ],
            [ null, 1.00, 'um real' ],
            [ null, 2.00, 'dois reais' ],
            [ null, 2.01, 'dois reais e um centavo' ],
            [ null, 2.50, 'dois reais e cinquenta centavos' ],

            [ null, 1000.01, 'mil reais e um centavo' ],
            [ null, 1101.01, 'mil, cento e um reais e um centavo' ],
            [ null, 1000000.01, 'um milhão de reais e um centavo' ],
            [ null, 1001001.01, 'um milhão, mil e um reais e um centavo' ],

            [ null, 2000.02, 'dois mil reais e dois centavos' ],
            [ null, 2000000.02, 'dois milhões de reais e dois centavos' ],
            [ null, 2002002.02, 'dois milhões, dois mil e dois reais e dois centavos' ],

            [ [ 'defaultCurrency' => 'dollar' ], 0, 'zero dólar' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1, 'um dólar' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2, 'dois dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1000, 'mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1001, 'mil e um dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1002, 'mil e dois dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1000000, 'um milhão de dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2000000, 'dois milhões de dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1001001, 'um milhão, mil e um dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1001001, 'um milhão, mil e um dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1002000000, 'um bilhão e dois milhões de dólares' ],

            [ [ 'defaultCurrency' => 'dollar' ], 1000, 'mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1001, 'mil e um dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1010, 'mil e dez dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1011, 'mil e onze dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1021, 'mil e vinte e um dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1100, 'mil e cem dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1101, 'mil, cento e um dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1111, 'mil, cento e onze dólares' ],

            [ [ 'defaultCurrency' => 'dollar' ], 2000, 'dois mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 3000, 'três mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 4000, 'quatro mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 5000, 'cinco mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 6000, 'seis mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 7000, 'sete mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 8000, 'oito mil dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 9000, 'nove mil dólares' ],

            [ [ 'defaultCurrency' => 'dollar' ], 0.01, 'um centavo' ],
            [ [ 'defaultCurrency' => 'dollar' ], 0.15, 'quinze centavos' ],

            [ [ 'defaultCurrency' => 'dollar' ], 0.00, 'zero dólar' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1.00, 'um dólar' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2.00, 'dois dólares' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2.01, 'dois dólares e um centavo' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2.50, 'dois dólares e cinquenta centavos' ],

            [ [ 'defaultCurrency' => 'dollar' ], 1000.01, 'mil dólares e um centavo' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1101.01, 'mil, cento e um dólares e um centavo' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1000000.01, 'um milhão de dólares e um centavo' ],
            [ [ 'defaultCurrency' => 'dollar' ], 1001001.01, 'um milhão, mil e um dólares e um centavo' ],

            [ [ 'defaultCurrency' => 'dollar' ], 2000.02, 'dois mil dólares e dois centavos' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2000000.02, 'dois milhões de dólares e dois centavos' ],
            [ [ 'defaultCurrency' => 'dollar' ], 2002002.02, 'dois milhões, dois mil e dois dólares e dois centavos' ],
        ];
    }
}
