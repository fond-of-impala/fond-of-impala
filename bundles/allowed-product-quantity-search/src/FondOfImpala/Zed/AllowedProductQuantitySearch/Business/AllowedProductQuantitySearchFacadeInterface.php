<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Business;

interface AllowedProductQuantitySearchFacadeInterface
{
    /**
     * Specification:
     * - Queries all allowedProductQuantity with allowedProductQuantityIds
     * - Stores data as json encoded to search table
     * - Sends a copy of data to queue based on module config
     *
     * @api
     *
     * @param array $allowedProductQuantityIds
     *
     * @return void
     */
    public function publish(array $allowedProductQuantityIds): void;

    /**
     * Specification:
     * - Finds and deletes allowedProductQuantity search entities with allowedProductQuantityIds
     * - Sends delete message to queue based on module config
     *
     * @api
     *
     * @param array $allowedProductQuantityIds
     *
     * @return void
     */
    public function unpublish(array $allowedProductQuantityIds): void;
}
