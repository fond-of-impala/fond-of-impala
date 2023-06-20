<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;

interface ConditionalAvailabilityPostSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered after conditional availability object is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function postSave(
        ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
    ): ConditionalAvailabilityResponseTransfer;
}
