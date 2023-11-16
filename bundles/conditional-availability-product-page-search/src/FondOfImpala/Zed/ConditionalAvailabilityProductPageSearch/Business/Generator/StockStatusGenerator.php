<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Generator;

use DateTime;
use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Exception\InvalidRawValueException;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;

class StockStatusGenerator implements StockStatusGeneratorInterface
{
    /**
     * @var string
     */
    public const PATTERN_STOCK_STATUS = '%s-%s';

    /**
     * @var array<int>
     */
    public const VALID_RAW_VALUES = [
        ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK,
        ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_LATER_IN_STOCK,
        ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_OUT_OF_STOCK,
    ];

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
     *
     * @return int
     */
    public function generateRawValueByConditionalAvailabilityPeriodCollection(
        ConditionalAvailabilityPeriodCollectionTransfer $conditionalAvailabilityPeriodCollectionTransfer
    ): int {
        $today = (new DateTime())->setTime(0, 0);
        $conditionalAvailabilityPeriodTransfers = $conditionalAvailabilityPeriodCollectionTransfer
            ->getConditionalAvailabilityPeriods();

        foreach ($conditionalAvailabilityPeriodTransfers as $conditionalAvailabilityPeriodTransfer) {
            $startAt = (new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt()))->setTime(0, 0);
            $endAt = (new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt()))->setTime(0, 0);
            $qty = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($qty > 0 && $startAt <= $today && $endAt >= $today) {
                return ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_IN_STOCK;
            }

            if ($qty > 0 && $startAt > $today) {
                return ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_LATER_IN_STOCK;
            }
        }

        return ConditionalAvailabilityProductPageSearchConfig::STOCK_STATUS_OUT_OF_STOCK;
    }

    /**
     * @param int $rawValue
     * @param string $channel
     *
     * @throws \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Exception\InvalidRawValueException
     *
     * @return string
     */
    public function generateByRawValueAndChannel(int $rawValue, string $channel): string
    {
        if (!in_array($rawValue, static::VALID_RAW_VALUES, true)) {
            throw new InvalidRawValueException(
                sprintf(
                    'Given raw value (%s) is invalid. Possible raw values are %s',
                    $rawValue,
                    implode('|', static::VALID_RAW_VALUES),
                ),
            );
        }

        return sprintf(static::PATTERN_STOCK_STATUS, $channel, $rawValue);
    }
}
