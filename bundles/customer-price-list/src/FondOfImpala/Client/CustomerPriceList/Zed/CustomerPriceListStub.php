<?php

namespace FondOfImpala\Client\CustomerPriceList\Zed;

use FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;

class CustomerPriceListStub implements CustomerPriceListStubInterface
{
    protected CustomerPriceListToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CustomerPriceListToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function expandCustomer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $url = '/customer-price-list/gateway/expand-customer';

        /** @var \Generated\Shared\Transfer\CustomerTransfer $customerTransfer */
        $customerTransfer = $this->zedRequestClient->call($url, $customerTransfer);

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollectionByIdCustomer(CustomerTransfer $customerTransfer): PriceListCollectionTransfer
    {
        $url = '/customer-price-list/gateway/get-price-list-collection-by-id-customer';

        /** @var \Generated\Shared\Transfer\PriceListCollectionTransfer $priceListCollectionTransfer */
        $priceListCollectionTransfer = $this->zedRequestClient->call($url, $customerTransfer);

        return $priceListCollectionTransfer;
    }
}
