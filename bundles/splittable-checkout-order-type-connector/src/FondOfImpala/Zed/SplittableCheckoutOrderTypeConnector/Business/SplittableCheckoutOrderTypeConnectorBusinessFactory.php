<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business;

use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\SalesOrderExpander;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\SalesOrderExpanderInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidator;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig getConfig()
 */
class SplittableCheckoutOrderTypeConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpanderInterface
     */
    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander($this->createOrderTypeValidator(), $this->getConfig());
    }

    /**
     * @return \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\SalesOrderExpanderInterface
     */
    public function createSalesOrderExpander(): SalesOrderExpanderInterface
    {
        return new SalesOrderExpander(
            $this->createOrderTypeValidator(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface
     */
    public function createOrderTypeValidator(): OrderTypeValidatorInterface
    {
        return new OrderTypeValidator($this->getAvailableOrderTypes());
    }

    /**
     * @return array<string>
     */
    public function getAvailableOrderTypes(): array
    {
        return $this->getProvidedDependency(SplittableCheckoutOrderTypeConnectorDependencyProvider::PROPEL_TABLE_MAP_ORDER_TYPES);
    }
}
