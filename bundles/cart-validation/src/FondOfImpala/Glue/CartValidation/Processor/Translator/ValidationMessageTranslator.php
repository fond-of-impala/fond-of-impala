<?php

namespace FondOfImpala\Glue\CartValidation\Processor\Translator;

use ArrayObject;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface;
use FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class ValidationMessageTranslator implements ValidationMessageTranslatorInterface
{
    /**
     * @var \FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface
     */
    protected $glossaryStorageClient;

    /**
     * @var \FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface
     */
    protected $localeClient;

    /**
     * @param \FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToGlossaryStorageClientInterface $glossaryStorageClient
     * @param \FondOfImpala\Glue\CartValidation\Dependency\Client\CartValidationToLocaleClientInterface $localeClient
     */
    public function __construct(
        CartValidationToGlossaryStorageClientInterface $glossaryStorageClient,
        CartValidationToLocaleClientInterface $localeClient
    ) {
        $this->glossaryStorageClient = $glossaryStorageClient;
        $this->localeClient = $localeClient;
    }

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     *
     * @return array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface>
     */
    public function translate(array $resources): array
    {
        foreach ($resources as $resource) {
            $this->translateOnQuoteLevel($resource);
            $this->translateOnQuoteItemLevel($resource);
        }

        return $resources;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $resource
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected function translateOnQuoteLevel(RestResourceInterface $resource): RestResourceInterface
    {
        $attributesTransfer = $resource->getAttributes();

        if ($attributesTransfer === null || !method_exists($attributesTransfer, 'getValidationMessages')) {
            return $resource;
        }

        $this->translateValidationMessages($attributesTransfer->getValidationMessages());

        return $resource;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $resource
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected function translateOnQuoteItemLevel(RestResourceInterface $resource): RestResourceInterface
    {
        foreach ($resource->getRelationships() as $resourceName => $relationshipResources) {
            if ($resourceName !== 'items') {
                continue;
            }

            foreach ($relationshipResources as $relationshipResource) {
                if (!($relationshipResource instanceof RestResource)) {
                    continue;
                }

                $attributesTransfer = $relationshipResource->getAttributes();

                if (!($attributesTransfer instanceof RestItemsAttributesTransfer)) {
                    continue;
                }

                $this->translateValidationMessages($attributesTransfer->getValidationMessages());
            }
        }

        return $resource;
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\MessageTransfer> $validationMessages
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\MessageTransfer>
     */
    protected function translateValidationMessages(ArrayObject $validationMessages): ArrayObject
    {
        foreach ($validationMessages as $validationMessage) {
            $this->translateValidationMessage($validationMessage);
        }

        return $validationMessages;
    }

    /**
     * @param \Generated\Shared\Transfer\MessageTransfer $messageTransfer
     *
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function translateValidationMessage(MessageTransfer $messageTransfer): MessageTransfer
    {
        if ($messageTransfer->getValue() === null) {
            return $messageTransfer;
        }

        $value = $this->glossaryStorageClient->translate(
            $messageTransfer->getValue(),
            $this->localeClient->getCurrentLocale(),
            $messageTransfer->getParameters(),
        );

        return $messageTransfer->setValue($value)
            ->setParameters([]);
    }
}
