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
