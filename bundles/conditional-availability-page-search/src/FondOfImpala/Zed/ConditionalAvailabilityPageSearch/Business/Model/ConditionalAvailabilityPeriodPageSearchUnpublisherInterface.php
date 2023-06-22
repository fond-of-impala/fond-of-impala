<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

interface ConditionalAvailabilityPeriodPageSearchUnpublisherInterface
{
    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function unpublish(array $conditionalAvailabilityIds): void;
}
