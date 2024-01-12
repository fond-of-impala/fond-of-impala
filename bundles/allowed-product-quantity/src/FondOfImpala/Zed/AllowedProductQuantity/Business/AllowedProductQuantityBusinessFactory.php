<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business;

use FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityReader;
use FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityReaderInterface;
use FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityWriter;
use FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\AllowedProductQuantityConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepositoryInterface getRepository()
 */
class AllowedProductQuantityBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityWriterInterface
     */
    public function createProductAbstractAllowedQuantityWriter(): ProductAbstractAllowedQuantityWriterInterface
    {
        return new ProductAbstractAllowedQuantityWriter($this->getEntityManager());
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityReaderInterface
     */
    public function createProductAbstractAllowedQuantityReader(): ProductAbstractAllowedQuantityReaderInterface
    {
        return new ProductAbstractAllowedQuantityReader($this->getRepository());
    }
}
