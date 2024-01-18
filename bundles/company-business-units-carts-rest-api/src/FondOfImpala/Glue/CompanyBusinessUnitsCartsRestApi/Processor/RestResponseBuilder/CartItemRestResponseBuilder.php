<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder;

use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class CartItemRestResponseBuilder implements CartItemRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface
     */
    protected $cartItemMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface $cartItemMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CartItemMapperInterface $cartItemMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->cartItemMapper = $cartItemMapper;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $cartResource
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param string $localeName
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function createCartItemResource(
        RestResourceInterface $cartResource,
        ItemTransfer $itemTransfer,
        string $localeName
    ): RestResourceInterface {
        $itemResource = $this->restResourceBuilder->createRestResource(
            CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_CART_ITEMS,
            $itemTransfer->getGroupKey(),
            $this->cartItemMapper->mapItemTransferToRestItemsAttributesTransfer(
                $itemTransfer,
                (new RestItemsAttributesTransfer()),
                $localeName,
            ),
        );

        return $this->addSelfLinkToCartItemResource($itemResource, $cartResource, $itemTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $itemResource
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $cartResource
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected function addSelfLinkToCartItemResource(
        RestResourceInterface $itemResource,
        RestResourceInterface $cartResource,
        ItemTransfer $itemTransfer
    ): RestResourceInterface {
        return $itemResource->addLink(
            RestLinkInterface::LINK_SELF,
            sprintf(
                '%s/%s/%s/%s',
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_CARTS,
                $cartResource->getId(),
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_CART_ITEMS,
                $itemTransfer->getGroupKey(),
            ),
        );
    }
}
