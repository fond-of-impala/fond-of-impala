<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business;

use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;

interface ConditionalAvailabilityBulkApiFacadeInterface
{
    /**
     * Specification:
     * - Persists conditional availabilities in bulk mode.
     * - Persists periods per persisted conditional availability.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function persistConditionalAvailabilities(ApiDataTransfer $apiDataTransfer): ApiItemTransfer;
}
