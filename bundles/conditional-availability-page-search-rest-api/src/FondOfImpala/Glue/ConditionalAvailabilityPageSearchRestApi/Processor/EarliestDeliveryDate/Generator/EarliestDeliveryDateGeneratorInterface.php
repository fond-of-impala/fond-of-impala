<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\EarliestDeliveryDate\Generator;

use DateTimeInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

interface EarliestDeliveryDateGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
     *
     * @return \DateTimeInterface|null
     */
    public function generateByRestConditionalAvailabilityPeriodTransfer(
        RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
    ): ?DateTimeInterface;
}
