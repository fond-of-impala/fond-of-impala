<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business;

use FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceListPriceWriter;
use FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceListPriceWriterInterface;
use FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceProductDimensionExpander;
use FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceProductDimensionExpanderInterface;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\PriceProductPriceList\PriceProductPriceListConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface getRepository()
 */
class PriceProductPriceListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceProductDimensionExpanderInterface
     */
    public function createPriceProductDimensionExpander(): PriceProductDimensionExpanderInterface
    {
        return new PriceProductDimensionExpander(
            $this->getPriceListFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface
     */
    protected function getPriceListFacade(): PriceProductPriceListToPriceListFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListDependencyProvider::FACADE_PRICE_LIST);
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceListPriceWriterInterface
     */
    public function createPriceListPriceWriter(): PriceListPriceWriterInterface
    {
        return new PriceListPriceWriter(
            $this->getPriceProductFacade(),
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface
     */
    protected function getPriceProductFacade(): PriceProductPriceListToPriceProductFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListDependencyProvider::FACADE_PRICE_PRODUCT);
    }
}
