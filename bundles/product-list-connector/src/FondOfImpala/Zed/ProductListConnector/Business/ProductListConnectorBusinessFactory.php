<?php

namespace FondOfImpala\Zed\ProductListConnector\Business;

use FondOfImpala\Zed\ProductListConnector\Business\Manager\ProductListManager;
use FondOfImpala\Zed\ProductListConnector\Business\Manager\ProductListManagerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepository getRepository()
 * @method \FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManager getEntityManager()
 */
class ProductListConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductListConnector\Business\Manager\ProductListManagerInterface
     */
    public function createProductListManager(): ProductListManagerInterface
    {
        return new ProductListManager(
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }
}
