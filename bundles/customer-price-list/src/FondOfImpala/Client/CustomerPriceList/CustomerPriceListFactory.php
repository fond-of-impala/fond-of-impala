<?php

namespace FondOfImpala\Client\CustomerPriceList;

use FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface;
use FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStub;
use FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CustomerPriceListFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStubInterface
     */
    public function createZedStub(): CustomerPriceListStubInterface
    {
        return new CustomerPriceListStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CustomerPriceListToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerPriceListDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
