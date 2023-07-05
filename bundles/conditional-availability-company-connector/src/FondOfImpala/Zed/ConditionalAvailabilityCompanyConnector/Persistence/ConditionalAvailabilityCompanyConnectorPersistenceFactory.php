<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorDependencyProvider;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ConditionalAvailabilityCompanyConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCompanyConnectorDependencyProvider::PROPEL_QUERY_COMPANY,
        );
    }
}
