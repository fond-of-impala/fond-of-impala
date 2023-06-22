<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;
use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery;

interface ConditionalAvailabilityPageSearchQueryContainerInterface
{
    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityPeriodQuery;

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityPeriodQuery;

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityQuery
     */
    public function queryConditionalAvailabilitiesByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): FoiConditionalAvailabilityQuery;
}
