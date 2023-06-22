<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

interface ConditionalAvailabilityPeriodPageSearchDataMapperInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function mapConditionalAvailabilityPeriodDataToSearchData(
        array $data
    ): array;
}
