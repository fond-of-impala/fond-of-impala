<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper;

use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityBulkApiMapper implements ConditionalAvailabilityBulkApiMapperInterface
{
    /**
     * @var string
     */
    protected const DATA_KEY_SKU = 'sku';

    /**
     * @var string
     */
    protected const DATA_KEY_WAREHOUSE_GROUP = 'warehouse_group';

    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return array<string, array<string, \Generated\Shared\Transfer\ConditionalAvailabilityTransfer>>
     */
    public function mapApiDataTransferToGroupedConditionalAvailabilityTransfers(
        ApiDataTransfer $apiDataTransfer
    ): array {
        $groupedConditionalAvailabilityTransfers = [];

        foreach ($apiDataTransfer->getData() as $item) {
            if (empty($item[static::DATA_KEY_SKU]) || empty($item[static::DATA_KEY_WAREHOUSE_GROUP])) {
                continue;
            }

            if (empty($groupedConditionalAvailabilityTransfers[$item[static::DATA_KEY_WAREHOUSE_GROUP]])) {
                $groupedConditionalAvailabilityTransfers[$item[static::DATA_KEY_WAREHOUSE_GROUP]] = [];
            }

            $conditionalAvailabilityTransfer = $this->mapDataToConditionalAvailabilityTransfer($item);
            $groupedConditionalAvailabilityTransfers[$item[static::DATA_KEY_WAREHOUSE_GROUP]][$item[static::DATA_KEY_SKU]] = $conditionalAvailabilityTransfer;
        }

        return $groupedConditionalAvailabilityTransfers;
    }

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    public function mapDataToConditionalAvailabilityTransfer(array $data): ConditionalAvailabilityTransfer
    {
        return (new ConditionalAvailabilityTransfer())
            ->fromArray($data, true);
    }
}
