<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business;

use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReader;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\QuoteReader;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\CompanyBusinessUnitQuoteConnectorDependencyProvider;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface getRepository()
 */
class CompanyBusinessUnitQuoteConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\QuoteReaderInterface
     */
    public function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader(
            $this->createCompanyUserReader(),
            $this->getCompanyUserReferenceQuoteConnectorFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\CompanyUserReaderInterface
     */
    protected function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getRepository(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyBusinessUnitQuoteConnectorToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitQuoteConnectorDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface
     */
    protected function getCompanyUserReferenceQuoteConnectorFacade(): CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitQuoteConnectorDependencyProvider::FACADE_COMPANY_USER_REFERENCE_QUOTE_CONNECTOR);
    }
}
