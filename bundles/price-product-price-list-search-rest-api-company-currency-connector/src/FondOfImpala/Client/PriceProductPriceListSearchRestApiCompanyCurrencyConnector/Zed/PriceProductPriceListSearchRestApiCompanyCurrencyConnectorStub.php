<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed;

use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface;
use Generated\Shared\Transfer\CurrencyTransfer;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub implements PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface
{
    protected PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface $zedRequestClient)
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
        $url = '/price-product-price-list-search-rest-api-company-currency-connector/gateway/get-currency-by-id';

        /** @var \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer */
        $currencyTransfer = $this->zedRequestClient->call($url, $currencyTransfer);

        return $currencyTransfer;
    }
}
