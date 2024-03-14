<?php

namespace FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication\Controller;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication\CompanyCurrencyPriceProductPriceListSearchRestApiCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrencyByIdAction(CurrencyTransfer $currencyTransfer): CurrencyTransfer
    {
        return $this->getFactory()->getCurrencyFacade()->getByIdCurrency($currencyTransfer->getIdCurrency());
    }
}
