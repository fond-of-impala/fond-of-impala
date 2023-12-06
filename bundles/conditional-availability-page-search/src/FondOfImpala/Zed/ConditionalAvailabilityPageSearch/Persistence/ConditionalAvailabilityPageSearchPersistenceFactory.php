<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodPageSearchMapper;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodPageSearchMapperInterface;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FoiConditionalAvailabilityPeriodPageSearchQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchRepositoryInterface getRepository()
 */
class ConditionalAvailabilityPageSearchPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\FoiConditionalAvailabilityPeriodPageSearchQuery
     */
    public function createConditionalAvailabilityPeriodPageSearchQuery(): FoiConditionalAvailabilityPeriodPageSearchQuery
    {
        return FoiConditionalAvailabilityPeriodPageSearchQuery::create();
    }

    /**
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function getConditionalAvailabilityPeriodPropelQuery(): FoiConditionalAvailabilityPeriodQuery
    {
        return $this->getProvidedDependency(ConditionalAvailabilityPageSearchDependencyProvider::PROPEL_QUERY_CONDITIONAL_AVAILABILITY_PERIOD);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodPageSearchMapperInterface
     */
    public function createConditionalAvailabilityPeriodPageSearchMapper(): ConditionalAvailabilityPeriodPageSearchMapperInterface
    {
        return new ConditionalAvailabilityPeriodPageSearchMapper();
    }
}
