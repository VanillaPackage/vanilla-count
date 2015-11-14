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
     * Spell a number.
     *
     * @param int $number Number to spelling.
     *
     * @return string
     */
    public function spell($number)
    {
        // Normalize numbers hardcoded to accept long numbers.
        $numberNormalized       = preg_replace('/\D/', null, $number);
        $numberNormalizedLength = ceil(strlen($numberNormalized) / 3) * 3;
        $numberNormalizedPadded = str_pad($numberNormalized, $numberNormalizedLength, '0', STR_PAD_LEFT);

        // Split numbers in lands (eg. *100.000* should be [ '100', '000' ])
        $numberLands        = array_reverse(str_split($numberNormalizedPadded, 3));
        $numberLandsSpelled = [ ];

        // Process each number lands and get a raw spelled term.
        // Eg. *1.002* should be (reversed) [ 'two', 'one' ].
        foreach ($numberLands as $numberLandKey => $numberLand) {
            // Stores the number land as integer, by ltrim *0* characters.
            $numberLands[$numberLandKey] = (int) ltrim($numberLand, '0');

            // Process the number in current land, getting it simplified spelling.
            $numberLandSpelled = $this->locale->simple($numberLands[$numberLandKey], $numberLandKey);

            // Numbers that can't be spelled naturally should be ignored.
            // A good example is *zero*, that will be processed only on formatter.
            if ($numberLandSpelled === null) {
                continue;
            }

            // Store the spelled number in the current land.
            $numberLandsSpelled[$numberLandKey] = $numberLandSpelled;
        }

        return $this->locale->format($numberLandsSpelled, $numberLands);
    }
}
