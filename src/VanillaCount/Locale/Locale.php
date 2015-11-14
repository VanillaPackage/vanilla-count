<?php

namespace Rentalhost\VanillaCount\Locale;

use Rentalhost\VanillaCount\Currency\Currency;
use Rentalhost\VanillaCount\Exception\CurrencyUnsupportedException;
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
     *
     * @return string|null
     */
    abstract public function simple($number);

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
    abstract public function format($locale, $numberLandsSpelled, $numberLands, $spellingType);

    /**
     * Returns the currency instance.
     * @throws CurrencyUnsupportedException If the defaultCurrency option contains an unsupported value.
     * @return Currency
     */
    protected function getCurrency()
    {
        $currency = $this->options->defaultCurrency;

        if (is_object($currency)) {
            // If currency is an instance of Currency, then use it directly.
            return $currency;
        }

        /** @noinspection NotOptimalIfConditionsInspection */
        if (is_subclass_of($currency, Currency::class)) {
            // Else, it can be a string representing a class instance, so get the instance.
            return $currency::getInstance();
        }

        $currency = preg_replace('/\\Currency$/', ucfirst($currency) . 'Currency', Currency::class);
        if (is_subclass_of($currency, Currency::class)) {
            // Else, it can be a string represeting one of prebuild classes, so get the instance.
            return $currency::getInstance();
        }

        throw new CurrencyUnsupportedException;
    }
}
