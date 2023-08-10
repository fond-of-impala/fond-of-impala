<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Dependency\Client;

use Generated\Shared\Transfer\PriceListListTransfer;

interface PriceListsRestApiToPriceListClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(PriceListListTransfer $priceListListTransfer): PriceListListTransfer;
}
