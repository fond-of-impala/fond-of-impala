<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

interface ConditionalAvailabilityPageSearchFacadeInterface
{
    /**
     * Specification:
     *  - Retrieve list of abstract product ids by concrete product ids.
     *
     * @api
     *
     * @param array<int> $concreteIds
     *
     * @return array<int>
     */
    public function getConditionalAvailabilityIdsByConcreteIds(array $concreteIds): array;

    /**
     * Specification:
     * - Queries all conditional availabilities with these ids
     * - Creates a data structure tree
     * - Stores data as json encoded to search table
     * - Sends a copy of data to queue based on module config
     *
     * @api
     *
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publish(array $conditionalAvailabilityIds): void;

    /**
     * Specification:
     * - Finds and deletes conditional availability period search entities based on these ids
     * - Sends delete message to queue based on module config
     *
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function unpublish(array $conditionalAvailabilityIds): void;
}
