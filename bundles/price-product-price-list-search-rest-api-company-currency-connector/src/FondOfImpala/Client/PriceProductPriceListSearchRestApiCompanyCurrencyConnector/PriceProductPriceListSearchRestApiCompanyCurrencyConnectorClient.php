<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory getFactory()
 */
class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient extends AbstractClient implements PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientInterface
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
