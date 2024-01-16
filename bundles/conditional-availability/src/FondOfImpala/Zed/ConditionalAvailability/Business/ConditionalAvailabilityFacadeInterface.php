<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailability\Business;

use ArrayObject;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

interface ConditionalAvailabilityFacadeInterface
{
    /**
     * Specifications:
     * - Finds conditional availability by id
     * - Requires ConditionalAvailabilityTransfer::idConditionalAvailability
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function findConditionalAvailabilityById(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * Specifications:
     * - Creates conditional availability
     * - Creates conditional availability periods optionally.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function createConditionalAvailability(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * Specifications:
     * - Persists conditional availability
     * - Persists conditional availability periods optionally.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function persistConditionalAvailability(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * Specifications:
     * - Requires ConditionalAvailabilityTransfer::idConditionalAvailability.
     * - Updates conditional availability.
     * - Updates conditional availability periods optionally.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function updateConditionalAvailability(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * Specifications:
     * - Requires ConditionalAvailabilityTransfer::idConditionalAvailability.
     * - Deletes conditional availability.
     * - Deletes conditional availability periods.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function deleteConditionalAvailability(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * Specifications:
     * - Persist conditional availability periods
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function persistConditionalAvailabilityPeriods(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityTransfer;

    /**
     * Specifications:
     * - Retrieves conditional availabilities by given filter.
     * - Groups conditional availabilities by sku (SKU => [ConditionalAvailabilityTransfer, ...], ...).
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function findGroupedConditionalAvailabilities(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ArrayObject;

    /**
     * Specifications:
     * - Retrieves conditional availabilities by given filter.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findConditionalAvailabilities(
        ConditionalAvailabilityCriteriaFilterTransfer $conditionalAvailabilityCriteriaFilterTransfer
    ): ConditionalAvailabilityCollectionTransfer;

    /**
     * Specifications:
     * - Retrieves conditional availability IDs by product concrete IDs.
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return array<int>
     */
    public function getConditionalAvailabilityIdsByProductConcreteIds(array $productConcreteIds): array;

    /**
     * Specifications:
     * - Retrieves conditional availabilities by ids
     *
     * @api
     *
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function getConditionalAvailabilitiesByIds(
        array $conditionalAvailabilityIds
    ): ConditionalAvailabilityCollectionTransfer;

    /**
     * Specifications:
     * - Retrieves conditional availabilities by product abstract ids
     *
     * @api
     *
     * @param array<int> $productAbstractIds
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    public function findConditionalAvailabilitiesByProductAbstractIds(
        array $productAbstractIds
    ): ConditionalAvailabilityCollectionTransfer;
}
