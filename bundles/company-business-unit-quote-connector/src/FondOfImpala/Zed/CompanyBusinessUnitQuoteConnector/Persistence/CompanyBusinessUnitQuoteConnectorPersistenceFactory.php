<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence;

use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\CompanyBusinessUnitQuoteConnectorDependencyProvider;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\Propel\Mapper\CompanyUserMapper;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\Propel\Mapper\CompanyUserMapperInterface;
use Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorRepositoryInterface getRepository()
 */
class CompanyBusinessUnitQuoteConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(
            CompanyBusinessUnitQuoteConnectorDependencyProvider::PROPEL_QUERY_COMPANY_USER,
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\Propel\Mapper\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }
}
