<?php

namespace Rentalhost\VanillaCount\Locale;

/**
 * Class eLocale
 * @package Rentalhost\VanillaCount
 */
abstract class Locale
{
    /**
     * Returns the simple spelling of a number.
     *
     * @param string $number The current hundred.
     * @param int    $land   The current number land (zero-based).
     *
     * @return string|null
     */
    abstract public function simple($number, $land);

    /**
     * Format the number lands to spelling.
     *
     * @param string[] $numberLandsSpelled The number lands spelled.
     * @param int[]    $numberLands        The original number lands (as integer).
     *
     * @return string|null
     */
    abstract public function format($numberLandsSpelled, $numberLands);
}
