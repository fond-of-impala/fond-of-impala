<?php

namespace FondOfImpala\Client\PriceList;

use FondOfImpala\Client\PriceList\Dependency\Client\PriceListToZedRequestClientInterface;
use FondOfImpala\Client\PriceList\Zed\PriceListStub;
use FondOfImpala\Client\PriceList\Zed\PriceListStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class PriceListFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\PriceList\Zed\PriceListStubInterface
     */
    public function createZedPriceListStub(): PriceListStubInterface
    {
        return new PriceListStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\PriceList\Dependency\Client\PriceListToZedRequestClientInterface
     */
    protected function getZedRequestClient(): PriceListToZedRequestClientInterface
    {
        return $this->getProvidedDependency(PriceListDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
