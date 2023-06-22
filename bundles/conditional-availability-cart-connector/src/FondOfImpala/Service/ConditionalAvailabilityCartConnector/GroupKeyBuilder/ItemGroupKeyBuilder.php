<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Generated\Shared\Transfer\ItemTransfer;

class ItemGroupKeyBuilder implements ItemGroupKeyBuilderInterface
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface
     */
    protected $groupKeyBuilder;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface $groupKeyBuilder
     */
    public function __construct(GroupKeyBuilderInterface $groupKeyBuilder)
    {
        $this->groupKeyBuilder = $groupKeyBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function build(ItemTransfer $itemTransfer): string
    {
        $deliveryDate = $itemTransfer->getDeliveryDate();
        $sku = $itemTransfer->getSku();

        if ($deliveryDate === null) {
            return $sku;
        }

        return $this->groupKeyBuilder->build($sku, $deliveryDate);
    }
}
