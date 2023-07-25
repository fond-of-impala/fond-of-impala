<?php

namespace FondOfImpala\Zed\CompanyType\Persistence;

use FondOfImpala\Zed\CompanyType\Persistence\Mapper\CompanyMapper;
use FondOfImpala\Zed\CompanyType\Persistence\Mapper\CompanyMapperInterface;
use FondOfImpala\Zed\CompanyType\Persistence\Mapper\CompanyTypeMapper;
use FondOfImpala\Zed\CompanyType\Persistence\Mapper\CompanyTypeMapperInterface;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyType\Persistence\FosCompanyTypeQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\CompanyType\CompanyTypeConfig getConfig()
 */
class CompanyTypePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyType\Persistence\FosCompanyTypeQuery
     */
    public function createCompanyTypeQuery(): FosCompanyTypeQuery
    {
        return FosCompanyTypeQuery::create();
    }

    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function createCompanyQuery(): SpyCompanyQuery
    {
            return SpyCompanyQuery::create();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyType\Persistence\Mapper\CompanyTypeMapperInterface
     */
    public function createCompanyTypeMapper(): CompanyTypeMapperInterface
    {
        return new CompanyTypeMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyType\Persistence\Mapper\CompanyMapperInterface
     */
    public function createCompanyMapper(): CompanyMapperInterface
    {
        return new CompanyMapper();
    }
}
