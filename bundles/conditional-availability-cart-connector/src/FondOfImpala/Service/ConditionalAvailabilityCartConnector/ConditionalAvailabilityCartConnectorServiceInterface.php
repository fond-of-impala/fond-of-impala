<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;

interface ConditionalAvailabilityCartConnectorServiceInterface
{
    /**
     * Specification:
     * - Build group key for quote item
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function buildItemGroupKey(ItemTransfer $itemTransfer): string;

    /**
     * Specification:
     * - Build group key for rest cart item
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return string
     */
    public function buildRestCartItemGroupKey(RestCartItemTransfer $restCartItemTransfer): string;
}
