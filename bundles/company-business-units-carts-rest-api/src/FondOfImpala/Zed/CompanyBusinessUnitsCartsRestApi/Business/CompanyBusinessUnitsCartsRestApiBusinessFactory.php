<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business;

use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\CompanyBusinessUnitReader;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\CompanyBusinessUnitReaderInterface;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\QuoteReader;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\RestCompanyBusinessUnitCartListMapper;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\RestCompanyBusinessUnitCartListMapperInterface;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence\CompanyBusinessUnitsCartsRestApiRepositoryInterface getRepository()
 */
class CompanyBusinessUnitsCartsRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\QuoteReaderInterface
     */
    public function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader(
            $this->createCompanyBusinessUnitReader(),
            $this->createRestCompanyBusinessUnitCartListMapper(),
            $this->getRepository(),
            $this->getCompanyBusinessUnitQuoteConnectorFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\CompanyBusinessUnitReaderInterface
     */
    protected function createCompanyBusinessUnitReader(): CompanyBusinessUnitReaderInterface
    {
        return new CompanyBusinessUnitReader(
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitsCartsRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface
     */
    protected function getCompanyBusinessUnitQuoteConnectorFacade(): CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitsCartsRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT_QUOTE_CONNECTOR);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\RestCompanyBusinessUnitCartListMapperInterface
     */
    protected function createRestCompanyBusinessUnitCartListMapper(): RestCompanyBusinessUnitCartListMapperInterface
    {
        return new RestCompanyBusinessUnitCartListMapper();
    }
}
