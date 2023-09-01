<?php

namespace FondOfImpala\Glue\CustomerPriceList;

use FondOfImpala\Glue\CustomerPriceList\Processor\Expander\CustomerExpander;
use FondOfImpala\Glue\CustomerPriceList\Processor\Expander\CustomerExpanderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\CustomerPriceList\CustomerPriceListClientInterface getClient()
 */
class CustomerPriceListFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CustomerPriceList\Processor\Expander\CustomerExpanderInterface
     */
    public function createCustomerExpander(): CustomerExpanderInterface
    {
        return new CustomerExpander($this->getClient());
    }
}
