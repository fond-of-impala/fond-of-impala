<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper;

use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator\GroupKeyGeneratorInterface;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityBulkApiMapper implements ConditionalAvailabilityBulkApiMapperInterface
{
    /**
     * @var string
     */
    protected const DATA_KEY_SKU = 'sku';

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator\GroupKeyGeneratorInterface
     */
    protected GroupKeyGeneratorInterface $groupKeyGenerator;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator\GroupKeyGeneratorInterface $groupKeyGenerator
     */
    public function __construct(GroupKeyGeneratorInterface $groupKeyGenerator)
    {
        $this->groupKeyGenerator = $groupKeyGenerator;
    }

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
            $groupKey = $this->groupKeyGenerator->generateByApiData($item);

            if ($groupKey === null || empty($item[static::DATA_KEY_SKU])) {
                continue;
            }

            if (empty($groupedConditionalAvailabilityTransfers[$groupKey])) {
                $groupedConditionalAvailabilityTransfers[$groupKey] = [];
            }

            $conditionalAvailabilityTransfer = $this->mapDataToConditionalAvailabilityTransfer($item);
            $groupedConditionalAvailabilityTransfers[$groupKey][$item[static::DATA_KEY_SKU]] = $conditionalAvailabilityTransfer;
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
