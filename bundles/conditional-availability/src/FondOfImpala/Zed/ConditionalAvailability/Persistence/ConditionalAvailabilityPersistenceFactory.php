<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Persistence;

use FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityMapper;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityMapperInterface;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodMapper;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodMapperInterface;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface getRepository()
 */
class ConditionalAvailabilityPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery
     */
    public function createConditionalAvailabilityQuery(): FoiConditionalAvailabilityQuery
    {
        return FoiConditionalAvailabilityQuery::create();
    }

    /**
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function createConditionalAvailabilityPeriodQuery(): FoiConditionalAvailabilityPeriodQuery
    {
        return FoiConditionalAvailabilityPeriodQuery::create();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityMapperInterface
     */
    public function createConditionalAvailabilityMapper(): ConditionalAvailabilityMapperInterface
    {
        return new ConditionalAvailabilityMapper($this->createConditionalAvailabilityPeriodMapper());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Persistence\Propel\Mapper\ConditionalAvailabilityPeriodMapperInterface
     */
    public function createConditionalAvailabilityPeriodMapper(): ConditionalAvailabilityPeriodMapperInterface
    {
        return new ConditionalAvailabilityPeriodMapper();
    }
}
