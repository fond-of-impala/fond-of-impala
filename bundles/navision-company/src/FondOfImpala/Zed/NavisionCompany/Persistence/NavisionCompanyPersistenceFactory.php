<?php

namespace FondOfImpala\Zed\NavisionCompany\Persistence;

use FondOfImpala\Zed\NavisionCompany\NavisionCompanyDependencyProvider;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\NavisionCompanyConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface getRepository()
 */
class NavisionCompanyPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(NavisionCompanyDependencyProvider::PROPEL_QUERY_COMPANY);
    }
}
