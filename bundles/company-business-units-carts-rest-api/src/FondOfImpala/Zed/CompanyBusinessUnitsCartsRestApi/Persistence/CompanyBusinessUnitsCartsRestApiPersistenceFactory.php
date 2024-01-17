<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence;

use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiDependencyProvider;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence\CompanyBusinessUnitsCartsRestApiRepositoryInterface getRepository()
 */
class CompanyBusinessUnitsCartsRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Quote\Persistence\SpyQuoteQuery
     */
    public function getQuoteQuery(): SpyQuoteQuery
    {
        return $this->getProvidedDependency(
            CompanyBusinessUnitsCartsRestApiDependencyProvider::PROPEL_QUERY_QUOTE,
        );
    }
}
