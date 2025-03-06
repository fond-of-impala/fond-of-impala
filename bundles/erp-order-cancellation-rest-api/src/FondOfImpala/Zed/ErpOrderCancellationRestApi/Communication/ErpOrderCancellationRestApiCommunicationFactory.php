<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication;

use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCustomerFacadeInterface;
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

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCustomerFacadeInterface
     */
    public function getCustomerFacade(): ErpOrderCancellationRestApiToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCompanyUserFacadeInterface
     */
    public function getCompanyUserReferenceFacade(): ErpOrderCancellationRestApiToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiToPermissionFacadeInterface
     */
    public function getPermissionFacade()
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_PERMISSION);
    }
}
