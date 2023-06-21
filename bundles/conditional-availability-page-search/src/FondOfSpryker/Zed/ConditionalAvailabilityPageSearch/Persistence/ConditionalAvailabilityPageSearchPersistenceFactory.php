<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodPageSearchMapper;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodPageSearchMapperInterface;
use Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityQuery;
use Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FosConditionalAvailabilityPeriodPageSearchQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchRepositoryInterface getRepository()
 */
class ConditionalAvailabilityPageSearchPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FosConditionalAvailabilityPeriodPageSearchQuery
     */
    public function createConditionalAvailabilityPeriodPageSearchQuery(): FosConditionalAvailabilityPeriodPageSearchQuery
    {
        return FosConditionalAvailabilityPeriodPageSearchQuery::create();
    }

    /**
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery
     */
    public function getConditionalAvailabilityPeriodPropelQuery(): FosConditionalAvailabilityPeriodQuery
    {
        return $this->getProvidedDependency(ConditionalAvailabilityPageSearchDependencyProvider::PROPEL_QUERY_CONDITIONAL_AVAILABILITY_PERIOD);
    }

    /**
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityQuery
     */
    public function getConditionalAvailabilityPropelQuery(): FosConditionalAvailabilityQuery
    {
        return $this->getProvidedDependency(ConditionalAvailabilityPageSearchDependencyProvider::PROPEL_QUERY_CONDITIONAL_AVAILABILITY);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodPageSearchMapperInterface
     */
    public function createConditionalAvailabilityPeriodPageSearchMapper(): ConditionalAvailabilityPeriodPageSearchMapperInterface
    {
        return new ConditionalAvailabilityPeriodPageSearchMapper();
    }
}
