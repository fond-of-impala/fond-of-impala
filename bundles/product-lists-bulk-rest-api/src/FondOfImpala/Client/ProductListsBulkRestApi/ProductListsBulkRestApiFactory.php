<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi;

use FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client\ProductListsBulkRestApiToZedRequestClientInterface;
use FondOfImpala\Client\ProductListsBulkRestApi\Zed\ProductListsBulkRestApiStub;
use FondOfImpala\Client\ProductListsBulkRestApi\Zed\ProductListsBulkRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ProductListsBulkRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\ProductListsBulkRestApi\Zed\ProductListsBulkRestApiStubInterface
     */
    public function createZedProductListsBulkRestApiStub(): ProductListsBulkRestApiStubInterface
    {
        return new ProductListsBulkRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client\ProductListsBulkRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): ProductListsBulkRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(ProductListsBulkRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
