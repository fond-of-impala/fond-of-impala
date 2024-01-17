<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemCalculationsTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

class CartItemMapper implements CartItemMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\RestItemsAttributesTransfer $restItemsAttributesTransfer
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    public function mapItemTransferToRestItemsAttributesTransfer(
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer,
        string $localeName
    ): RestItemsAttributesTransfer {
        $restItemsAttributesTransfer->fromArray($itemTransfer->toArray(), true);

        $restCartItemCalculationsTransfer = $restItemsAttributesTransfer->getCalculations();
        if (!$restCartItemCalculationsTransfer) {
            $restCartItemCalculationsTransfer = new RestCartItemCalculationsTransfer();
        }

        return $restItemsAttributesTransfer->setCalculations(
            $restCartItemCalculationsTransfer->fromArray($itemTransfer->toArray(), true),
        );
    }
}
