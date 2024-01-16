<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CartValidation;

use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface;
use FondOfImpala\Glue\CartValidation\Processor\Translator\ValidationMessageTranslator;
use FondOfImpala\Glue\CartValidation\Processor\Translator\ValidationMessageTranslatorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CartValidationFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CartValidation\Processor\Translator\ValidationMessageTranslatorInterface
     */
    public function createValidationMessageTranslator(): ValidationMessageTranslatorInterface
    {
        return new ValidationMessageTranslator(
            $this->getGlossaryStorageClient(),
            $this->getLocaleClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface
     */
    public function getGlossaryStorageClient(): CartValidationToGlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(CartValidationDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }

    /**
     * @return \FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface
     */
    public function getLocaleClient(): CartValidationToLocaleClientInterface
    {
        return $this->getProvidedDependency(CartValidationDependencyProvider::CLIENT_LOCALE);
    }
}
