<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Generated\Shared\Transfer\RestCartItemTransfer;

class RestCartItemGroupKeyBuilder implements RestCartItemGroupKeyBuilderInterface
{
    protected GroupKeyBuilderInterface $groupKeyBuilder;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface $groupKeyBuilder
     */
    public function __construct(GroupKeyBuilderInterface $groupKeyBuilder)
    {
        $this->groupKeyBuilder = $groupKeyBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return string
     */
    public function build(RestCartItemTransfer $restCartItemTransfer): string
    {
        $deliveryDate = $restCartItemTransfer->getDeliveryDate();
        $sku = $restCartItemTransfer->getSku();

        if ($deliveryDate === null) {
            return $sku;
        }

        return $this->groupKeyBuilder->build($sku, $deliveryDate);
    }
}
