<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension;

use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;
use Spryker\Glue\Kernel\AbstractFactory;

class QuantityRestConditionalAvailabilityPeriodMapperPlugin extends AbstractFactory implements RestConditionalAvailabilityPeriodMapperPluginInterface
{
    /**
     * @var string
     */
    protected const PERIOD_DATA_KEY_QUANTITY = 'quantity';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $periodData
     * @param \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
     *
     * @return \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer
     */
    public function mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
        array $periodData,
        RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
    ): RestConditionalAvailabilityPeriodTransfer {
        if (!isset($periodData[static::PERIOD_DATA_KEY_QUANTITY])) {
            return $restConditionalAvailabilityPeriodTransfer;
        }

        return $restConditionalAvailabilityPeriodTransfer->setQty($periodData[static::PERIOD_DATA_KEY_QUANTITY]);
    }
}
