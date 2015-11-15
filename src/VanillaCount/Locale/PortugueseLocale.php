<?php

namespace Rentalhost\VanillaCount\Locale;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Currency\Currency;
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
        'simpleSpells'             => [
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
        'simpleSpellsFemale'       => [
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
        'millionRoots'             => [
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
        'millionSuffixes'          => [
            'ão',
            'ões',
        ],

        /** @var boolean Include the *um* to thousand (eg. *um mil* instead of *mil*). */
        'includeOneThousand'       => false,

        /** @var string Zero is exclusively spelled as is when number is exactly it. */
        'zeroSpell'                => 'zero',

        /** @var string Hundred is exclusively spelled as is when number is exactly it. */
        'hundredSpell'             => 'cem',

        /** @var string Thousand is spelled for numbers over one thousand. */
        'thousandSpell'            => 'mil',

        /** @var string Separator used in default cases (eg. *um milhão, mil e um*). */
        'defaultSeparator'         => ', ',

        /** @var string Separator used in lasts lands (eg. *mil e um*). */
        'lastSeparator'            => ' e ',

        /** @var string The number gender (eg. *dois* for male or *duas* for female). */
        'gender'                   => self::GENDER_MALE,

        /** @var string The currency separator for high amount (eg. *um milhão de reais*). */
        'currencySeparator'        => ' de ',

        /** @var string The currency decimal separator (eg. *um real e dois centavos*). */
        'currencyDecimalSeparator' => ' e ',

        /** @var string|Currency The default currency of this locale. */
        'defaultCurrency'          => 'real',

        /** @var string|Locale The default locale to use on currency. */
        'defaultLocale'            => 'pt',
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
     *
     * @return string|null
     */
    public function simple($number)
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
                   ( $this->options->lastSeparator ?: ' ' ) .
                   $this->simple((int) substr($numberString, 1));
        }

        if ($number > 20) {
            $numberString = (string) $number;

            // If number is over 20, then combine that.
            return $this->options->simpleSpells[$numberString[0] . '0'] .
                   ( $this->options->lastSeparator ?: ' ' ) .
                   $this->options->simpleSpells[$numberString[1]];
        }

        return null;
    }

    /**
     * Format the number lands to spelling.
     *
     * @param Locale   $locale             The locale used to spell numbers.
     * @param string[] $numberLandsSpelled The number lands spelled.
     * @param int[]    $numberLands        The original number lands (as integer).
     * @param string   $spellingType       The spelling type.
     *
     * @return null|string
     */
    public function format($locale, $numberLandsSpelled, $numberLands, $spellingType)
    {
        if (!$numberLandsSpelled) {
            // If no lands, then spells zero.
            return $this->formatType($this->options->zeroSpell, 0, $numberLandsSpelled, Count::SIDE_INTEGER, $spellingType);
        }

        $numberLandsCount = count($numberLandsSpelled);
        if ($numberLandsCount === 1 && array_key_exists('0', $numberLandsSpelled)) {
            // Simple spell with only the first land (1 to 999).
            return $this->formatType($numberLandsSpelled[0], $numberLands[0], $numberLandsSpelled, Count::SIDE_INTEGER, $spellingType);
        }

        // Reprocess all lands, applying the suffixes.
        $numberLandsKeys = array_keys($numberLandsSpelled);
        foreach ($numberLandsKeys as $numberLandsKey) {
            if ($numberLandsKey === 1) {
                if ($this->options->includeOneThousand !== true && $numberLands[$numberLandsKey] === 1) {
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

            if ($numberLandsKey === -1) {
                // Consider decimals ten times less.
                $numberLandsSpelled[$numberLandsKey] = $locale->simple($numberLands[$numberLandsKey] / 10);
                continue;
            }
        }

        // Currency: if decimal was defined, so we get it first.
        $numberLandsDecimal = null;
        if (array_key_exists('-1', $numberLandsSpelled)) {
            $numberLandsCount--;

            $numberLandsDecimal = $this->formatType(
                $numberLandsSpelled[-1],
                $numberLands[-1] / 10,
                $numberLandsSpelled,
                Count::SIDE_DECIMAL,
                $spellingType);

            unset( $numberLands[-1], $numberLandsSpelled[-1] );
        }

        // If there are just one land, just return it.
        // Currency: it's always pluralized because numbers where is always greater or equal to one thousand.
        $numberResult = null;
        if ($numberLandsCount === 1) {
            $numberResult = $this->formatType(reset($numberLandsSpelled), 2, $numberLandsSpelled, Count::SIDE_INTEGER, $spellingType);
        }
        else if ($numberLandsCount > 1) {
            // If the first land is equal or lower than 100, the result will be treated differently.
            // Or if the first land is divisible by 100 (eg. *200*, but not *201*).
            // In this case, it'll group the last land by *e* instead of comma.
            $numberLandsFirst = reset($numberLands);
            if ($numberLandsFirst <= 100 || $numberLandsFirst % 100 === 0) {
                $numberLandsReverse = array_reverse($numberLandsSpelled);
                $numberResult       = implode($this->options->defaultSeparator ?: ' ', array_slice($numberLandsReverse, 0, -1)) .
                                      ( $this->options->lastSeparator ?: ' ' ) .
                                      end($numberLandsReverse);
            }
            else {
                // Else, just implode all by comma.
                $numberResult = implode($this->options->defaultSeparator ?: ' ', array_reverse($numberLandsSpelled));
            }

            // Compose the integer result.
            $numberResult = $this->formatType($numberResult, 2, $numberLandsSpelled, Count::SIDE_INTEGER, $spellingType);
        }

        // Currency: if decimals exists, just append it to result.
        if ($numberLandsDecimal) {
            if ($numberResult) {
                $numberResult .= $this->options->currencyDecimalSeparator;
            }

            $numberResult .= $numberLandsDecimal;
        }

        return $numberResult;
    }

    /**
     * Format the spelled value based on type.
     *
     * @param string   $spelledValue       The spelled value.
     * @param int      $value              The value.
     * @param string[] $numberLandsSpelled The spelled numbers.
     * @param string   $spellingSide       The spelling part (integer or decimal).
     * @param string   $spellingType       The spelling type.
     *
     * @return string
     */
    private function formatType($spelledValue, $value, $numberLandsSpelled, $spellingSide, $spellingType)
    {
        // Format currencies.
        if ($spellingType === Count::SPELLING_CURRENCY) {
            end($numberLandsSpelled);

            $currencyLocalized = $this->getCurrency()->getLocaleCallable($this->options->defaultLocale);
            $currencySuffix    = call_user_func($currencyLocalized, $spellingSide, $value);
            $currencyLong      = $numberLandsSpelled &&
                                 $spellingSide === Count::SIDE_INTEGER &&
                                 $this->options->currencySeparator &&
                                 !array_key_exists('0', $numberLandsSpelled) &&
                                 !array_key_exists('1', $numberLandsSpelled) &&
                                 key($numberLandsSpelled) >= 2;

            return $spelledValue .
                   ( $currencyLong ? $this->options->currencySeparator : ' ' ) .
                   $currencySuffix;
        }

        // Result the spelled value, only.
        return $spelledValue;
    }
}
