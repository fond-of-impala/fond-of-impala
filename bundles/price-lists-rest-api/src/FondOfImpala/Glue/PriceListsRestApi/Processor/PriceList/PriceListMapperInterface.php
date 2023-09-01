<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList;

use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\RestPriceListAttributesTransfer;

interface PriceListMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     * @param \Generated\Shared\Transfer\RestPriceListAttributesTransfer $restPriceListAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestPriceListAttributesTransfer
     */
    public function mapPriceListTransferToRestPriceListAttributesTransfer(
        PriceListTransfer $priceListTransfer,
        RestPriceListAttributesTransfer $restPriceListAttributesTransfer
    ): RestPriceListAttributesTransfer;
}
