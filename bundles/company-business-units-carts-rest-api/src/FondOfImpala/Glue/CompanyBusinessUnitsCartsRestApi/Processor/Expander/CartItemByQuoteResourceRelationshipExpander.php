<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander;

use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartItemByQuoteResourceRelationshipExpander implements CartItemByQuoteResourceRelationshipExpanderInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface
     */
    protected $cartItemRestResponseBuilder;

    /**
     * @param \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface $cartItemRestResponseBuilder
     */
    public function __construct(CartItemRestResponseBuilderInterface $cartItemRestResponseBuilder)
    {
        $this->cartItemRestResponseBuilder = $cartItemRestResponseBuilder;
    }

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        foreach ($resources as $resource) {
            /**
             * @var \Generated\Shared\Transfer\QuoteTransfer|null $quoteTransfer
             */
            $quoteTransfer = $resource->getPayload();
            if (!$quoteTransfer instanceof QuoteTransfer) {
                continue;
            }

            foreach ($quoteTransfer->getItems() as $itemTransfer) {
                $itemResource = $this->cartItemRestResponseBuilder->createCartItemResource(
                    $resource,
                    $itemTransfer,
                    $restRequest->getMetadata()->getLocale(),
                );

                $resource->addRelationship($itemResource);
            }
        }
    }
}
