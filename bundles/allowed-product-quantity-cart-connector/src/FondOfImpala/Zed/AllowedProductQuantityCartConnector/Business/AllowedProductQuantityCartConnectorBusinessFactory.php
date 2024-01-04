<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter\AbstractSkuFilter;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter\AbstractSkuFilterInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReader;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReaderInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemsValidator;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemsValidatorInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidator;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidatorInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidator;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidatorInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorConfig getConfig()
 */
class AllowedProductQuantityCartConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidatorInterface
     */
    public function createQuoteValidator(): QuoteValidatorInterface
    {
        return new QuoteValidator($this->createItemsValidator());
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidatorInterface
     */
    public function createItemValidator(): ItemValidatorInterface
    {
        return new ItemValidator(
            $this->createAllowedProductQuantityReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemsValidatorInterface
     */
    protected function createItemsValidator(): ItemsValidatorInterface
    {
        return new ItemsValidator(
            $this->createAllowedProductQuantityReader(),
            $this->createItemValidator(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReaderInterface
     */
    protected function createAllowedProductQuantityReader(): AllowedProductQuantityReaderInterface
    {
        return new AllowedProductQuantityReader(
            $this->createAbstractSkuFilter(),
            $this->getAllowedProductQuantityFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter\AbstractSkuFilterInterface
     */
    protected function createAbstractSkuFilter(): AbstractSkuFilterInterface
    {
        return new AbstractSkuFilter();
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface
     */
    protected function getAllowedProductQuantityFacade(): AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface
    {
        return $this->getProvidedDependency(AllowedProductQuantityCartConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY);
    }
}
