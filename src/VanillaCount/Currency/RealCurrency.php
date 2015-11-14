<?php

namespace Rentalhost\VanillaCount\Currency;

/**
 * Class RealCurrency
 * @package Rentalhost\VanillaCount\Currency
 */
class RealCurrency extends Currency
{
    /**
     * RealCurrency constructor.
     */
    public function __construct()
    {
        // Main currency name (pt, pt-BR).
        $this->addLocaleCommon('pt', 'real', 'reais', 'centavo', 'centavos');

        // Translations.
        $this->addLocaleCommon('en', 'real', 'reais', 'cent', 'cents');

        // Aliases.
        $this->addLocaleAlias('es', 'pt');
    }
}
