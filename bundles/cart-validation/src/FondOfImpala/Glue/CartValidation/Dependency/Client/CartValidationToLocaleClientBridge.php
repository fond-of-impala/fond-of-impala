<?php

namespace FondOfImpala\Glue\CartValidation\Dependency\Client;

use Spryker\Client\Locale\LocaleClientInterface;

class CartValidationToLocaleClientBridge implements CartValidationToLocaleClientInterface
{
    /**
     * @var \Spryker\Client\Locale\LocaleClientInterface
     */
    protected $localeClient;

    /**
     * @param \Spryker\Client\Locale\LocaleClientInterface $localeClient
     */
    public function __construct(LocaleClientInterface $localeClient)
    {
        $this->localeClient = $localeClient;
    }

    /**
     * @return string
     */
    public function getCurrentLocale(): string
    {
        return $this->localeClient->getCurrentLocale();
    }
}
