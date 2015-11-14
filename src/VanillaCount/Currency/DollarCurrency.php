<?php

namespace Rentalhost\VanillaCount\Currency;

/**
 * Class DollarCurrency
 * @package Rentalhost\VanillaCount\Currency
 */
class DollarCurrency extends Currency
{
    /**
     * DollarCurrency constructor.
     */
    public function __construct()
    {
        // Main currency name (en, en-US, en-GB).
        $this->addLocaleCommon('en', 'dollar', 'dollars', 'cent', 'cents');

        // Translations.
        $this->addLocaleCommon('pt', 'dólar', 'dólares', 'centavo', 'centavos');

        // Aliases.
        $this->addLocaleAlias('es', 'pt');
    }
}
