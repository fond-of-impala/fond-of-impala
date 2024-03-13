<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

interface ConditionalAvailabilityPageSearchFacadeInterface
{
    /**
     * Specification:
     * - Queries all conditional availabilities with these ids
     * - Creates a data structure tree
     * - Stores data as json encoded to search table
     * - Sends a copy of data to queue based on module config
     *
     * @api
     *
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function publish(string $eventName, array $eventEntityTransfers): void;

    /**
     * Specification:
     * - Queries conditional availabilities by keys
     * - Creates a data structure tree
     * - Stores data as json encoded to search table
     * - Sends a copy of data to queue based on module config
     *
     * @api
     *
     * @param array<string> $keys
     *
     * @return void
     */
    public function publishByKeys(array $keys): void;

    /**
     * Specification:
     * - Queries conditional availabilities by conditional availability ids
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
    public function publishByConditionalAvailabilityIds(
        array $conditionalAvailabilityIds
    ): void;

    /**
     * Specification:
     * - Finds and deletes conditional availability period search entities based on these ids
     * - Sends delete message to queue based on module config
     *
     * @api
     *
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function unpublish(string $eventName, array $eventEntityTransfers): void;
}
