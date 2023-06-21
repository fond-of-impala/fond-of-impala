<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

interface ConditionalAvailabilityWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function create(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function update(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function persist(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function delete(
        ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
    ): ConditionalAvailabilityResponseTransfer;
}
