<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ItemTransfer;

interface DeliveryDateGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function generateConcreteByItem(ItemTransfer $itemTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
     *
     * @return string
     */
    public function generateEarliestByConditionalAvailabilityPeriod(
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
    ): string;
}
