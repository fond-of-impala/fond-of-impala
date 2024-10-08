<?php

namespace FondOfImpala\Client\ErpOrderCancellationRestApi;

use FondOfImpala\Client\ErpOrderCancellationRestApi\Dependency\Client\ErpOrderCancellationRestApiToZedRequestClientInterface;
use FondOfImpala\Client\ErpOrderCancellationRestApi\Zed\ErpOrderCancellationRestApiStub;
use FondOfImpala\Client\ErpOrderCancellationRestApi\Zed\ErpOrderCancellationRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ErpOrderCancellationRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\ErpOrderCancellationRestApi\Zed\ErpOrderCancellationRestApiStubInterface
     */
    public function createZedErpOrderCancellationRestApiStub(): ErpOrderCancellationRestApiStubInterface
    {
        return new ErpOrderCancellationRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\ErpOrderCancellationRestApi\Dependency\Client\ErpOrderCancellationRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): ErpOrderCancellationRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
