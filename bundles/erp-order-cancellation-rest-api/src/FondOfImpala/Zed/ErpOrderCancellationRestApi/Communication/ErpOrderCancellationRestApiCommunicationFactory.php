<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication;

use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class ErpOrderCancellationRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     */
    public function getErpOrderFacade(): ErpOrderCancellationRestApiToErpOrderFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER);
    }
}
