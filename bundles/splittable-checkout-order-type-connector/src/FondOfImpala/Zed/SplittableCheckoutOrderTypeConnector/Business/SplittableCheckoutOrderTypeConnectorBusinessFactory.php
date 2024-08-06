<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business;

use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Persistence\SplittableCheckoutOrderTypeConnectorRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig getConfig()()
 */
class SplittableCheckoutOrderTypeConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpanderInterface
     */
    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander();
    }
}
