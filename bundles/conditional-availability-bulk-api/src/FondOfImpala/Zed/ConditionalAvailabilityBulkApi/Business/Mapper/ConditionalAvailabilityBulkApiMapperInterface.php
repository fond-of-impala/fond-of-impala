<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper;

use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

interface ConditionalAvailabilityBulkApiMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return array<string, array<string, \Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function mapApiDataTransferToGroupedConditionalAvailabilityTransfers(
        ApiDataTransfer $apiDataTransfer
    ): array;

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function mapDataToConditionalAvailabilityTransfer(
        array $data
    ): ConditionalAvailabilityTransfer;
}
