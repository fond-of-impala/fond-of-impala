<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

interface CartItemMapperInterface
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
    ): RestItemsAttributesTransfer;
}
