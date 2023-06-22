<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityQuery;

interface ConditionalAvailabilityPageSearchQueryContainerInterface
{
    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FosConditionalAvailabilityPeriodQuery;

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FosConditionalAvailabilityPeriodQuery;

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FosConditionalAvailabilityQuery
     */
    public function queryConditionalAvailabilitiesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FosConditionalAvailabilityQuery;
}
