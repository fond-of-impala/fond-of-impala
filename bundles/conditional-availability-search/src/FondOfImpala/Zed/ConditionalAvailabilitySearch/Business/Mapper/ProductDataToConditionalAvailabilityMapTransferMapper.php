<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Business\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\ConditionalAvailabilitySearch\Business\ConditionalAvailability\ProductDataToConditionalAvailabilityMapTransferMapperInterface;

class ProductDataToConditionalAvailabilityMapTransferMapper implements ProductDataToConditionalAvailabilityMapTransferMapperInterface
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
    ): ConditionalAvailabilityMapTransfer {
        return $conditionalAvailabilityMapTransfer->fromArray($productData[ProductPageSearchTransfer::CONDITIONAL_AVAILABILITY_MAP]);
    }
}
