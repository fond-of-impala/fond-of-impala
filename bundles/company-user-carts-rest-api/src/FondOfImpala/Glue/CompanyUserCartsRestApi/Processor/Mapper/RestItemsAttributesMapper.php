<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemCalculationsTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

class RestItemsAttributesMapper implements RestItemsAttributesMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    public function fromItem(ItemTransfer $itemTransfer): RestItemsAttributesTransfer
    {
        $restCartItemCalculationsTransfer = (new RestCartItemCalculationsTransfer())
            ->fromArray($itemTransfer->toArray(), true);

        return (new RestItemsAttributesTransfer())
            ->fromArray($itemTransfer->toArray(), true)
            ->setCalculations($restCartItemCalculationsTransfer);
    }
}
