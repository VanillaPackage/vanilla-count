<?php

namespace Rentalhost\VanillaCount\Locale;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Currency\Currency;

/**
 * Class EnglishLocale
 * @package Rentalhost\VanillaCount
 */
class EnglishLocale extends Locale
{
    /**
     * Locale options.
     * @var array
     */
    protected $options = [
        /** @var string[] Simple spells. Basically, spells from 1 to 100. Other spells bellow one thousand are compound. */
        'simpleSpells'             => [
            1  => 'one',
            2  => 'two',
            3  => 'three',
            4  => 'four',
            5  => 'five',
            6  => 'six',
            7  => 'seven',
            8  => 'eight',
            9  => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
        ],

        /** @var string[] Thousand and million spells. */
        'highSpells'               => [
            'thousand',
            'million',
            'billion',
            'trillion',
            'quadrillion',
            'quintillion',
            'sextillion',
            'septillion',
            'octillion',
            'nonillion',
            'decillion',
        ],

        /** @var string In case of *one something*, use *a* or *one* (eg. *a thousand* or *one thousand*). */
        'firstOneIdentifier'       => 'one',

        /** @var string Zero is exclusively spelled as is when number is exactly it. */
        'zeroSpell'                => 'zero',

        /** @var string Defines the hundred spell. */
        'hundredSpell'             => ' hundred',

        /** @var string Defines the hundred separator (eg. *one hundred and one*). */
        'hundredSeparator'         => ' and ',

        /** @var string Separator used on compound numbers (eg. *twenty-one*). */
        'compoundSeparator'        => '-',

        /** @var string Separator used in default cases (eg. *one million, one thousand and one*). */
        'defaultSeparator'         => ', ',

        /** @var string Separator used in lasts lands (eg. *one thousand and one*). */
        'lastSeparator'            => ' and ',

        /** @var string The currency separator for high amount (eg. *one million of dollars*). */
        'currencySeparator'        => null,

        /** @var string The currency decimal separator (eg. *one dollar and two cents*). */
        'currencyDecimalSeparator' => ' and ',

        /** @var string|Currency The default currency of this locale. */
        'defaultCurrency'          => 'dollar',

        /** @var string|Locale The default locale to use on currency. */
        'defaultLocale'            => 'en',
    ];

    /**
     * Returns the simple spelling of a number.
     *
     * @param int $number The current hundred.
     *
     * @return string|null
     */
    public function simple($number)
    {
        // If locale was defined directly, so use that.
        if (array_key_exists($number, $this->options->simpleSpells)) {
            return $this->options->simpleSpells[$number];
        }

        // If number is over 100, then combine (eg. *one hundred and twenty-one*).
        if ($number >= 100) {
            $numberString = (string) $number;
            $numberResult = $this->options->simpleSpells[$numberString[0]] .
                            $this->options->hundredSpell;

            if ($number % 100 !== 0) {
                $numberResult .=
                    ( $this->options->hundredSeparator ?: ' ' ) .
                    $this->simple((int) substr($numberString, 1));
            }

            return $numberResult;
        }

        // If number is over 20, then combine that (eg. *twenty-one*).
        if ($number > 20) {
            $numberString = (string) $number;

            return $this->options->simpleSpells[$numberString[0] . '0'] .
                   ( $this->options->compoundSeparator ?: ' ' ) .
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
            // If current number value is over 100 and starts with 1, we should apply first one identifier.
            if ($this->options->firstOneIdentifier !== 'one' && $numberLands[0] >= 100 && strpos($numberLands[0], '1') === 0) {
                $numberLandsSpelled[0] = str_replace(
                    'one ',
                    $this->options->firstOneIdentifier ? $this->options->firstOneIdentifier . ' ' : null,
                    $numberLandsSpelled[0]
                );
            }

            // Simple spell with only the first land (1 to 999).
            return $this->formatType($numberLandsSpelled[0], $numberLands[0], $numberLandsSpelled, Count::SIDE_INTEGER, $spellingType);
        }

        /** @var int $numberLandsKey */
        // Reprocess all lands, applying the suffixes.
        end($numberLandsSpelled);
        $numberLandsKeysLast = key($numberLandsSpelled);
        $numberLandsKeys     = array_keys($numberLandsSpelled);
        foreach ($numberLandsKeys as $numberLandsKey) {
            // Numbers over one thousand.
            if ($numberLandsKey >= 1) {
                // If current number value is one and is the first one spelled,
                // we should apply the first one identifier option.
                if ($numberLandsKey === $numberLandsKeysLast &&
                    $numberLands[$numberLandsKey] === 1
                ) {
                    $numberLandsSpelled[$numberLandsKey] =
                        ( $this->options->firstOneIdentifier ? $this->options->firstOneIdentifier . ' ' : null ) .
                        $this->options->highSpells[$numberLandsKey - 1];
                    continue;
                }

                $numberLandsSpelled[$numberLandsKey] .= ' ' . $this->options->highSpells[$numberLandsKey - 1];
                continue;
            }

            // Consider decimals ten times less.
            if ($numberLandsKey === -1) {
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
                $numberResult .= $this->options->currencyDecimalSeparator ?: ' ';
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
