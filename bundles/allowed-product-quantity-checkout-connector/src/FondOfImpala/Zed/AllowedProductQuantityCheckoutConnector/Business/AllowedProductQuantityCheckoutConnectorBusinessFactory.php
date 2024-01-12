<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business;

use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\AllowedProductQuantityCheckoutConnectorDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model\CheckoutPreConditionChecker;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model\CheckoutPreConditionCheckerInterface;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\AllowedProductQuantityCheckoutConnectorConfig getConfig()
 */
class AllowedProductQuantityCheckoutConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model\CheckoutPreConditionCheckerInterface
     */
    public function createCheckoutPreConditionChecker(): CheckoutPreConditionCheckerInterface
    {
        return new CheckoutPreConditionChecker($this->getAllowedProductQuantityCartConnectorFacade());
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface
     */
    protected function getAllowedProductQuantityCartConnectorFacade(): AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface
    {
        return $this->getProvidedDependency(AllowedProductQuantityCheckoutConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY_CART_CONNECTOR);
    }
}
