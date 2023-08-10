<?php

namespace FondOfImpala\Zed\PriceProductPriceListGui\Communication;

use FondOfImpala\Zed\PriceProductPriceListGui\Communication\Form\DataProvider\PriceListPriceDimensionFormDataProvider;
use FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade\PriceProductPriceListGuiToPriceListFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListGui\PriceProductPriceListGuiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListGui\PriceProductPriceListGuiConfig getConfig()
 */
class PriceProductPriceListGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListGui\Communication\Form\DataProvider\PriceListPriceDimensionFormDataProvider
     */
    public function createPriceListPriceDimensionFormDataProvider(): PriceListPriceDimensionFormDataProvider
    {
        return new PriceListPriceDimensionFormDataProvider(
            $this->getPriceListFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade\PriceProductPriceListGuiToPriceListFacadeInterface
     */
    public function getPriceListFacade(): PriceProductPriceListGuiToPriceListFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListGuiDependencyProvider::FACADE_PRICE_LIST);
    }
}
