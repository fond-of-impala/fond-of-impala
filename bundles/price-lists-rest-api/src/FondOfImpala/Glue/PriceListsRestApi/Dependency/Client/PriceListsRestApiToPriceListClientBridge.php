<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Dependency\Client;

use FondOfImpala\Client\PriceList\PriceListClientInterface;
use Generated\Shared\Transfer\PriceListListTransfer;

class PriceListsRestApiToPriceListClientBridge implements PriceListsRestApiToPriceListClientInterface
{
    protected PriceListClientInterface $priceListClient;

    /**
     * @param \FondOfImpala\Client\PriceList\PriceListClientInterface $priceListClient
     */
    public function __construct(PriceListClientInterface $priceListClient)
    {
        $this->priceListClient = $priceListClient;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(PriceListListTransfer $priceListListTransfer): PriceListListTransfer
    {
        return $this->priceListClient->findPriceLists($priceListListTransfer);
    }
}
