<?php

namespace Spryker\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailability;

use Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer;

interface ProductDataToConditionalAvailabilityMapTransferMapperInterface
{
    /**
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer $conditionalAvailabilityMapTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer
     */
    public function mapProductDataToConditionalAvailabilityMapTransfer(
        array $productData,
        ConditionalAvailabilityMapTransfer $conditionalAvailabilityMapTransfer
    ): ConditionalAvailabilityMapTransfer;
}
