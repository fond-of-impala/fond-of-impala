<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business;

use FondOfImpala\Zed\ProductProductListConnector\Business\Manager\ProductListManager;
use FondOfImpala\Zed\ProductProductListConnector\Business\Manager\ProductListManagerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepository getRepository()
 * @method \FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManager getEntityManager()
 */
class ProductProductListConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductProductListConnector\Business\Manager\ProductListManagerInterface
     */
    public function createProductListManager(): ProductListManagerInterface
    {
        return new ProductListManager(
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }
}
