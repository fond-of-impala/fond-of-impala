<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiFactory getFactory()
 */
class CompanyCurrencyPriceProductPriceListSearchRestApiClient extends AbstractClient implements CompanyCurrencyPriceProductPriceListSearchRestApiClientInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrencyById(CurrencyTransfer $currencyTransfer): CurrencyTransfer
    {
        return $this->getFactory()->createZedStub()->getCurrencyById($currencyTransfer);
    }
}
