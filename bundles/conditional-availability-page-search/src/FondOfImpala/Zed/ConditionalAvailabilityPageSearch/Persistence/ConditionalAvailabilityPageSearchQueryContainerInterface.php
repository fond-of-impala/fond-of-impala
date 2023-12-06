<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence;

use Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery;

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
     * @param array<string> $keys
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByKeys(
        array $keys
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
     * @param array<string> $keys
     *
     * @return \Orm\Zed\ConditionalAvailability\Persistence\FoiConditionalAvailabilityPeriodQuery
     */
    public function queryConditionalAvailabilityPeriodsByKeys(
        array $keys
    ): FoiConditionalAvailabilityPeriodQuery;
}
