<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;

interface ItemMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function fromRestCartItem(RestCartItemTransfer $restCartItemTransfer): ItemTransfer;
}
