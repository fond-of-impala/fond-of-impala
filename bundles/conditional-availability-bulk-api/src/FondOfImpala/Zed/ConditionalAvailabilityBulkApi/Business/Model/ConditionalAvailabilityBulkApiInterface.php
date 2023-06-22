<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model;

use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;

interface ConditionalAvailabilityBulkApiInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function persist(ApiDataTransfer $apiDataTransfer): ApiItemTransfer;
}
