<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi;

use FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client\OrderBudgetsBulkRestApiToZedRequestClientInterface;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed\OrderBudgetsBulkRestApiStub;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed\OrderBudgetsBulkRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class OrderBudgetsBulkRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed\OrderBudgetsBulkRestApiStubInterface
     */
    public function createZedOrderBudgetsBulkRestApiStub(): OrderBudgetsBulkRestApiStubInterface
    {
        return new OrderBudgetsBulkRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client\OrderBudgetsBulkRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): OrderBudgetsBulkRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(OrderBudgetsBulkRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
