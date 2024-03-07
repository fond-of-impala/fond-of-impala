<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

interface ConditionalAvailabilityPeriodPageSearchPublisherInterface
{
    /**
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function publish(string $eventName, array $eventEntityTransfers): void;

    /**
     * @param array<string> $keys
     *
     * @return void
     */
    public function publishByKeys(array $keys): void;

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publishByConditionalAvailabilityIds(array $conditionalAvailabilityIds): void;
}
