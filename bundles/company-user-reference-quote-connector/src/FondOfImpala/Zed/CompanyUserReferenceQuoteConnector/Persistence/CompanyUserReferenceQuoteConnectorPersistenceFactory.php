<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence;

use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\CompanyUserReferenceQuoteConnectorDependencyProvider;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepositoryInterface getRepository()
 */
class CompanyUserReferenceQuoteConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Quote\Persistence\SpyQuoteQuery
     */
    public function getQuoteQuery(): SpyQuoteQuery
    {
        return $this->getProvidedDependency(
            CompanyUserReferenceQuoteConnectorDependencyProvider::PROPEL_QUERY_QUOTE,
        );
    }
}
