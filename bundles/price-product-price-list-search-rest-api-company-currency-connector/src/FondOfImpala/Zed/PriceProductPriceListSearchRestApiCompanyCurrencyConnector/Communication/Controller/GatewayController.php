<?php

namespace FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Communication\Controller;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Communication\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCurrencyByIdAction(CurrencyTransfer $currencyTransfer): CurrencyTransfer
    {
        return $this->getFactory()->getCurrencyFacade()->getByIdCurrency($currencyTransfer->getIdCurrency());
    }
}
