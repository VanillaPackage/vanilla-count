<?php

namespace Rentalhost\VanillaCount\Locale;

use Rentalhost\VanillaData\Data;

/**
 * Class eLocale
 * @package Rentalhost\VanillaCount
 */
abstract class Locale
{
    /**
     * Gender constants.
     */
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * Locale options.
     * @var Data
     */
    protected $options;

    /**
     * Locale constructor.
     *
     * @param Data|array|null $options Options to locale.
     */
    public function __construct($options = null)
    {
        $this->options = Data::extend($this->options, $options);
    }

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
