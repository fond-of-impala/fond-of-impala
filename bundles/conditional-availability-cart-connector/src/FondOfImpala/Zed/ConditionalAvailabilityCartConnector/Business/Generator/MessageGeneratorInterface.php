<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use Generated\Shared\Transfer\MessageTransfer;

interface MessageGeneratorInterface
{
    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    public function createNotAvailableForGivenDeliveryDateMessage(): MessageTransfer;

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    public function createNotAvailableForEarliestDeliveryDateMessage(): MessageTransfer;

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    public function createNotAvailableForGivenQytMessage(): MessageTransfer;
}
