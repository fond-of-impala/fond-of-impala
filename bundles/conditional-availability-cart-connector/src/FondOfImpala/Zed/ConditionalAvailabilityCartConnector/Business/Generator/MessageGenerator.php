<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use Generated\Shared\Transfer\MessageTransfer;

class MessageGenerator implements MessageGeneratorInterface
{
    /**
     * @var string
     */
    public const TYPE_ERROR = 'error';

    /**
     * @var string
     */
    public const VALUE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE = 'conditional_availability_cart_connector.not_available_for_given_delivery_date';

    /**
     * @var string
     */
    public const VALUE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE = 'conditional_availability_cart_connector.not_available_for_earliest_delivery_date';

    /**
     * @var string
     */
    protected const VALUE_NOT_AVAILABLE_FOR_GIVEN_QTY = 'conditional_availability_cart_connector.not_available_for_given_qty';

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    public function createNotAvailableForGivenDeliveryDateMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::TYPE_ERROR)
            ->setValue(static::VALUE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE);

        return $messageTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    public function createNotAvailableForEarliestDeliveryDateMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::TYPE_ERROR)
            ->setValue(static::VALUE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE);

        return $messageTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    public function createNotAvailableForGivenQytMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::TYPE_ERROR)
            ->setValue(static::VALUE_NOT_AVAILABLE_FOR_GIVEN_QTY);

        return $messageTransfer;
    }
}
