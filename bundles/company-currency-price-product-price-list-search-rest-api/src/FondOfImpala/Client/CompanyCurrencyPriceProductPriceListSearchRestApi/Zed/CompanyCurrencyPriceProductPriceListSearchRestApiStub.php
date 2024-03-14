<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed;

use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CurrencyTransfer;

class CompanyCurrencyPriceProductPriceListSearchRestApiStub implements CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface
{
    protected CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrencyById(CurrencyTransfer $currencyTransfer): CurrencyTransfer
    {
        $url = '/company-currency-price-product-price-list-search-rest-api/gateway/get-currency-by-id';

        /** @var \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer */
        $currencyTransfer = $this->zedRequestClient->call($url, $currencyTransfer);

        return $currencyTransfer;
    }
}
