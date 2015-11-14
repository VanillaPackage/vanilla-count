<?php

namespace Rentalhost\VanillaCount\Currency;

use Rentalhost\VanillaCount\Count;
use Rentalhost\VanillaCount\Exception\LocaleCallableUndefinedException;
use Rentalhost\VanillaCount\Exception\LocaleUndefinedException;

/**
 * Class Currency
 * @package Rentalhost\VanillaCount\Currency
 */
abstract class Currency
{
    /**
     * Stores all currencies locales handlers.
     * @var callable[]
     */
    protected $locales = [ ];

    /**
     * Stores the default locales.
     * @var string[]
     */
    protected $defaultLocales = [ ];

    /**
     * Stores this currency instance.
     * @var self[]
     */
    static protected $instances = [ ];

    /**
     * Return the unique instance of this class.
     * @return Currency
     */
    public static function getInstance()
    {
        if (!array_key_exists(static::class, self::$instances)) {
            self::$instances[static::class] = new static;
        }

        return self::$instances[static::class];
    }

    /**
     * Returns the locale splitted and normalized (eg. *pt.BR* returns [ 'pt', 'pt-BR' ]).
     * It's limited to two parts.
     *
     * @param string $locale Locale to split.
     *
     * @return string[]
     */
    private static function getLocaleSplitted($locale)
    {
        $localeSplitted      = array_filter(preg_split('/[^a-z0-9]+/i', trim($locale), 3));
        $localeSplittedCount = count($localeSplitted);

        // Empty locale.
        if (!$localeSplittedCount) {
            return [ ];
        }

        // Only one locale found.
        $localeFirstLower = strtolower($localeSplitted[0]);
        if ($localeSplittedCount === 1) {
            return [ $localeFirstLower ];
        }

        // Multilocales.
        $locales = [
            $localeFirstLower,
            $localeFirstLower . '-' . strtoupper($localeSplitted[1]),
        ];

        // Uncommon locale.
        if ($localeSplittedCount === 3) {
            $locales[] = $locales[1] . '-' . trim($localeSplitted[2]);
        }

        return $locales;
    }

    /**
     * Returns the locale normalized (eg. *pt.BR* returns *pt-BR*).
     *
     * @param string $locale Locale to normalize.
     *
     * @return string|null
     */
    private static function getLocaleNormalized($locale)
    {
        $locales = static::getLocaleSplitted($locale);

        return end($locales) ?: null;
    }

    /**
     * Add a new currency localization.
     *
     * @param string   $locale   Locale to set.
     * @param callable $callable Response callable.
     *
     * @throws LocaleUndefinedException
     */
    protected function addLocale($locale, $callable)
    {
        $locale = static::getLocaleNormalized($locale);

        if ($locale === null) {
            throw new LocaleUndefinedException;
        }

        if (!$this->locales) {
            // Set this locale as default, if it's the first one.
            $this->setDefaultLocale($locale);
        }

        // Add the new currency.
        $this->locales[$locale] = $callable;
    }

    /**
     * Add a locale using the same callable from the base.
     *
     * @param string $alias The alias to this locale.
     * @param string $base  The base locale name.
     *
     * @throws LocaleUndefinedException If base locale is undefined.
     */
    protected function addLocaleAlias($alias, $base)
    {
        $alias = static::getLocaleNormalized($alias);
        $base  = static::getLocaleNormalized($base);

        if (!array_key_exists($base, $this->locales)) {
            throw new LocaleUndefinedException;
        }

        $this->locales[$alias] = $this->locales[$base];
    }

    /**
     * Add a common locale that follow this rule: value lower or equal one is singular, else plural.
     *
     * @param string $locale          Locale to set.
     * @param string $integerSingular Singular term to integer.
     * @param string $integerPlural   Plural term to integer.
     * @param string $decimalSingular Singular term to decimal.
     * @param string $decimalPlural   Pluram term to decimal.
     */
    protected function addLocaleCommon($locale, $integerSingular, $integerPlural, $decimalSingular, $decimalPlural)
    {
        $this->addLocale($locale, function ($type, $value) use ($integerSingular, $integerPlural, $decimalSingular, $decimalPlural) {
            if ($type === Count::SIDE_INTEGER) {
                return $value <= 1 ? $integerSingular : $integerPlural;
            }

            return $value <= 1 ? $decimalSingular : $decimalPlural;
        });
    }

    /**
     * Set the default currency locale.
     * It'll be used case the localization is unavailable (default is first added, *en* or none).
     *
     * @param string $locale Default locale to set.
     */
    protected function setDefaultLocale($locale)
    {
        $this->defaultLocales = static::getLocaleSplitted($locale);
    }

    /**
     * Get locales ordered by priority.
     * Will priorize the mainLocale, then alternativeLocales, lastly defaultLocales.
     *
     * @param string        $mainLocale         The main locale.
     * @param string[]|null $alternativeLocales The alternative locales.
     *
     * @return string[]
     */
    private function getLocalesOrdered($mainLocale, $alternativeLocales)
    {

        // Prepare the callable possibilities.
        $locales = [ $this->defaultLocales ];

        if ($alternativeLocales) {
            $alternativeLocales = array_map([ static::class, 'getLocaleSplitted' ], array_reverse($alternativeLocales));
            $locales[]          = call_user_func_array('array_merge', $alternativeLocales);
        }

        $locales[] = static::getLocaleSplitted($mainLocale);

        return array_reverse(array_unique(call_user_func_array('array_merge', $locales)));
    }

    /**
     * Get a specific locale.
     * If it fails, alternatives can be used, else, will use default locale.
     *
     * @param string        $mainLocale   Locale handler to return.
     * @param string[]|null $alternatives Alternative locales to return if main fail.
     *
     * @throws LocaleCallableUndefinedException
     * @return callable|null
     */
    public function getLocaleCallable($mainLocale, $alternatives = null)
    {
        $locales = $this->getLocalesOrdered($mainLocale, $alternatives);

        // Use the first possible callable.
        foreach ($locales as $locale) {
            if (array_key_exists($locale, $this->locales)) {
                return $this->locales[$locale];
            }
        }

        throw new LocaleCallableUndefinedException;
    }
}
