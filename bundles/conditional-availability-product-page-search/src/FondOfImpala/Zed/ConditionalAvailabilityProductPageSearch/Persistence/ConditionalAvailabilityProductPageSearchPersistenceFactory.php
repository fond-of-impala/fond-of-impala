<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityMapper;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\Propel\Mapper\ConditionalAvailabilityMapperInterface;
use Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ConditionalAvailabilityProductPageSearchPersistenceFactory extends AbstractPersistenceFactory
{

    /**
     * @return \Orm\Zed\ConditionalAvailabilityProductPageSearch\Persistence\Base\FoiConditionalAvailabilityQuery
     */
    public function createFoiConditionalAvailabilityQuery(): FoiConditionalAvailabilityQuery
    {
        return FoiConditionalAvailabilityQuery::create();
    }
}
