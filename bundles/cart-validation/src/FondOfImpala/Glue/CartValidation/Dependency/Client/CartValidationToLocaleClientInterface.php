<?php

namespace FondOfImpala\Glue\CartValidation\Dependency\Client;

interface CartValidationToLocaleClientInterface
{
    /**
     * @return string
     */
    public function getCurrentLocale(): string;
}
