<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business;

use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpander;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpanderInterface;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReader;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface getRepository()
 */
class CustomerPriceListBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpanderInterface
     */
    public function createCustomerExpander(): CustomerExpanderInterface
    {
        return new CustomerExpander($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReaderInterface
     */
    public function createCustomerPriceListReader(): CustomerPriceListReaderInterface
    {
        return new CustomerPriceListReader($this->getRepository());
    }
}
