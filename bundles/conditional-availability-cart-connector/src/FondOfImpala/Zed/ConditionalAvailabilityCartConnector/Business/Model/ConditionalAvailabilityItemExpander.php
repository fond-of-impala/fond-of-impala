<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;

class ConditionalAvailabilityItemExpander implements ConditionalAvailabilityItemExpanderInterface
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected $conditionalAvailabilityCartConnectorService;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface $conditionalAvailabilityCartConnectorService
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorServiceInterface $conditionalAvailabilityCartConnectorService
    ) {
        $this->conditionalAvailabilityCartConnectorService = $conditionalAvailabilityCartConnectorService;
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expand(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        foreach ($cartChangeTransfer->getItems() as $itemTransfer) {
            $itemTransfer->setGroupKey($this->buildGroupKey($itemTransfer));
        }

        return $cartChangeTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    protected function buildGroupKey(ItemTransfer $itemTransfer): string
    {
        return $this->conditionalAvailabilityCartConnectorService->buildItemGroupKey($itemTransfer);
    }
}
