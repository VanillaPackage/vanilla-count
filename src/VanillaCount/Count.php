<?php

namespace Rentalhost\VanillaCount;

use Rentalhost\VanillaCount\Locale\Locale;

/**
 * Class Count
 * @package Rentalhost\VanillaCount
 */
class Count
{
    /**
     * Constants to spelling types.
     */
    const SPELLING_NUMBER = 'number';
    const SPELLING_CURRENCY = 'currency';

    /**
     * Constants of number side (eg. 1.05 => 1 integer, 5 decimal).
     */
    const SIDE_INTEGER = 'integer';
    const SIDE_DECIMAL = 'decimal';

    /**
     * Stores the Locale.
     * @var Locale
     */
    private $locale;

    /**
     * Count constructor.
     *
     * @param Locale $locale Locale of instance.
     */
    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    /**
     * Normalize numbers hardcoded to accept long numbers.
     *
     * @param string|int $number        Number to normalize.
     * @param int        $numberPadding Number padding type.
     *
     * @return string
     */
    private static function normalizeNumber($number, $numberPadding = STR_PAD_LEFT)
    {
        $numberNormalized       = preg_replace('/\D/', null, $number);
        $numberNormalizedLength = ceil(strlen($numberNormalized) / 3) * 3;

        return str_pad($numberNormalized, $numberNormalizedLength, '0', $numberPadding);
    }

    /**
     * Get number in reversed lands (eg. *100.500* returns [ '500', '100' ]).
     * To decimal numbers, it uses the PHP's default decimal separator: dot.
     *
     * @param string $number Number to convert.
     *
     * @return string[]
     */
    private static function getNumberLands($number)
    {
        $number = trim($number);

        if (preg_match('/\./', $number, $numberLandsDecimalMatch, PREG_OFFSET_CAPTURE)) {
            // Check by the decimal part.
            $numberLands = array_reverse(str_split(static::normalizeNumber(substr($number, 0, $numberLandsDecimalMatch[0][1])), 3));

            $numberLandsDecimalsKeyed = [ ];
            $numberLandsDecimals      = str_split(static::normalizeNumber(substr($number, $numberLandsDecimalMatch[0][1]), STR_PAD_RIGHT), 3);

            foreach ($numberLandsDecimals as $key => $numberLandsDecimal) {
                $numberLandsDecimalsKeyed[-$key - 1] = $numberLandsDecimal;
            }

            $numberLands = array_replace(array_reverse($numberLandsDecimalsKeyed, true), $numberLands);
        }
        else {
            // Else, use full number.
            $numberLands = array_reverse(str_split(static::normalizeNumber($number), 3));
        }

        foreach ($numberLands as &$numberLand) {
            $numberLand = (int) ltrim($numberLand, '0');
        }

        return $numberLands;
    }

    /**
     * Spell a number.
     *
     * @param int    $number Number to spelling.
     * @param string $type   Tye type of spelling.
     *
     * @return string
     */
    public function spell($number, $type = self::SPELLING_NUMBER)
    {
        // Split numbers in lands (eg. *100.000* should be [ 0, 100 ])
        $numberLands        = static::getNumberLands($number);
        $numberLandsSpelled = [ ];

        // Process each number lands and get a raw spelled term.
        // Eg. *1.002* should be (reversed) [ 'two', 'one' ].
        foreach ($numberLands as $numberLandKey => $numberLand) {
            // Process the number in current land, getting it simplified spelling.
            $numberLandSpelled = $this->locale->simple($numberLands[$numberLandKey]);

            // Numbers that can't be spelled naturally should be ignored.
            // A good example is *zero*, that will be processed only on formatter.
            if ($numberLandSpelled === null) {
                continue;
            }

            // Store the spelled number in the current land.
            $numberLandsSpelled[$numberLandKey] = $numberLandSpelled;
        }

        /** @var int[] $numberLands */
        return $this->locale->format($this->locale, $numberLandsSpelled, $numberLands, $type);
    }
}
