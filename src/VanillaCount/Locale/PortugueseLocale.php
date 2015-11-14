<?php

namespace Rentalhost\VanillaCount\Locale;

use Rentalhost\VanillaData\Data;

/**
 * Class PortugueseLocale
 * @package Rentalhost\VanillaCount
 */
class PortugueseLocale extends Locale
{
    /**
     * Locale options.
     * @var array
     */
    protected $options = [
        /** @var string[] Simple spells. Basically, spells from 1 to 900. Other spells bellow one thousand are compound. */
        'simpleSpells'       => [
            1   => 'um',
            2   => 'dois',
            3   => 'três',
            4   => 'quatro',
            5   => 'cinco',
            6   => 'seis',
            7   => 'sete',
            8   => 'oito',
            9   => 'nove',
            10  => 'dez',
            11  => 'onze',
            12  => 'doze',
            13  => 'treze',
            14  => 'quatorze',
            15  => 'quinze',
            16  => 'dezesseis',
            17  => 'dezessete',
            18  => 'dezoito',
            19  => 'dezenove',
            20  => 'vinte',
            30  => 'trinta',
            40  => 'quarenta',
            50  => 'cinquenta',
            60  => 'sessenta',
            70  => 'setenta',
            80  => 'oitenta',
            90  => 'noventa',
            100 => 'cento',
            200 => 'duzentos',
            300 => 'trezentos',
            400 => 'quatrocentos',
            500 => 'quinhentos',
            600 => 'seiscentos',
            700 => 'setecentos',
            800 => 'oitocentos',
            900 => 'novecentos',
        ],

        /** @var string[] Simple spells in female gender. It'll complement the base simple spells. */
        'simpleSpellsFemale' => [
            1   => 'uma',
            2   => 'duas',
            100 => 'cento',
            200 => 'duzentas',
            300 => 'trezentas',
            400 => 'quatrocentas',
            500 => 'quinhentas',
            600 => 'seiscentas',
            700 => 'setecentas',
            800 => 'oitocentas',
            900 => 'novecentas',
        ],

        /** @var string[] Root of spells over millions. */
        'millionRoots'       => [
            'milh',
            'bilh',
            'trilh',
            'quatrilh',
            'quintilh',
            'sextilh',
            'septilh',
            'octilh',
            'nonilh',
            'decilh',
        ],

        /** @var string[] Suffixes to millions numbers (singular and plural). */
        'millionSuffixes'    => [
            'ão',
            'ões',
        ],

        /** @var string Zero is exclusively spelled as is when number is exactly it. */
        'zeroSpell'          => 'zero',

        /** @var string Hundred is exclusively spelled as is when number is exactly it. */
        'hundredSpell'       => 'cem',

        /** @var string Thousand is spelled for numbers over one thousand. */
        'thousandSpell'      => 'mil',

        /** @var string Separator used in default cases (eg. *um milhão, mil e um*). */
        'defaultSeparator'   => ',',

        /** @var string Separator used in lasts lands (eg. *mil e um*). */
        'lastSeparator'      => 'e',

        /** @var string The number gender (eg. *dois* for male or *duas* for female). */
        'gender'             => self::GENDER_MALE,
    ];

    /**
     * Locale constructor.
     *
     * @param Data|array|null $options Options to locale.
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        if ($this->options->gender === static::GENDER_FEMALE) {
            // Apply the female gender to simple spells.
            $this->options->simpleSpells = array_replace($this->options->simpleSpells, $this->options->simpleSpellsFemale);
        }
    }

    /**
     * Returns the simple spelling of a number.
     *
     * @param int $number The current hundred.
     * @param int $land   The current number land (zero-based).
     *
     * @return string|null
     */
    public function simple($number, $land)
    {
        if ($number === 100) {
            // When 100, returned the hundred named.
            return $this->options->hundredSpell;
        }

        if (array_key_exists($number, $this->options->simpleSpells)) {
            // If locale was defined directly, so use that.
            return $this->options->simpleSpells[$number];
        }

        if ($number > 100) {
            $numberString = (string) $number;

            // If number is over 100, then combine.
            return $this->options->simpleSpells[$numberString[0] . '00'] .
                   ' ' . $this->options->lastSeparator . ' ' .
                   $this->simple((int) substr($numberString, 1), $land);
        }

        if ($number > 20) {
            $numberString = (string) $number;

            // If number is over 20, then combine that.
            return $this->options->simpleSpells[$numberString[0] . '0'] .
                   ' ' . $this->options->lastSeparator . ' ' .
                   $this->options->simpleSpells[$numberString[1]];
        }

        return null;
    }

    /**
     * Format the number lands to spelling.
     *
     * @param string[] $numberLandsSpelled The number lands spelled.
     * @param int[]    $numberLands        The original number lands (as integer).
     *
     * @return string|null
     */
    public function format($numberLandsSpelled, $numberLands)
    {
        if (!$numberLandsSpelled) {
            // If no lands, then spells zero.
            return $this->options->zeroSpell;
        }

        $numberLandsCount = count($numberLandsSpelled);
        if ($numberLandsCount === 1 && array_key_exists('0', $numberLandsSpelled)) {
            // Simple spell with only the first land (1 to 999).
            return $numberLandsSpelled[0];
        }

        // Reprocess all lands, applying the suffixes.
        $numberLandsKeys = array_keys($numberLandsSpelled);
        foreach ($numberLandsKeys as $numberLandsKey) {
            if ($numberLandsKey === 1) {
                if ($numberLands[$numberLandsKey] === 1) {
                    // Exclusively for the one thousand, just use suffix (*um mil* to *mil*).
                    $numberLandsSpelled[$numberLandsKey] = $this->options->thousandSpell;
                    continue;
                }

                // Else, just append the thousand suffix (*dois* to *dois mil*).
                $numberLandsSpelled[$numberLandsKey] .= ' ' . $this->options->thousandSpell;
                continue;
            }

            if ($numberLandsKey >= 2) {
                // Numbers over one million.
                // Stores the million root (eg. *milh*) and the million suffix (eg. *ões*).
                // Together it'll be *milhões* if number is over 2 millions.
                $millionRoot   = $this->options->millionRoots[$numberLandsKey - 2];
                $millionSuffix = $this->options->millionSuffixes[$numberLands[$numberLandsKey] >= 2];

                $numberLandsSpelled[$numberLandsKey] .= ' ' . $millionRoot . $millionSuffix;
                continue;
            }
        }

        // If there are just one land, just return it.
        if ($numberLandsCount === 1) {
            return array_pop($numberLandsSpelled);
        }

        // If the first land is equal or lower than 100, the result will be treated differently.
        // Or if the first land is divisible by 100 (eg. *200*, but not *201*).
        // In this case, it'll group the last land by *e* instead of comma.
        $numberLandsFirst = reset($numberLands);
        if ($numberLandsFirst <= 100 || $numberLandsFirst % 100 === 0) {
            $numberLandsReverse = array_reverse($numberLandsSpelled);

            return implode($this->options->defaultSeparator . ' ', array_slice($numberLandsReverse, 0, -1)) .
                   ' ' . $this->options->lastSeparator . ' ' .
                   end($numberLandsReverse);
        }

        // Else, just implode all by comma.
        return implode($this->options->defaultSeparator . ' ', array_reverse($numberLandsSpelled));
    }
}
