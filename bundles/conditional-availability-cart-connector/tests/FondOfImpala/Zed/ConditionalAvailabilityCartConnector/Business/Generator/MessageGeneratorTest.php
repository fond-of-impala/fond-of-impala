<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MessageTransfer;

class MessageGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface
     */
    protected MessageGeneratorInterface $messageGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->messageGenerator = new MessageGenerator();
    }

    /**
     * @return void
     */
    public function testCreateNotAvailableForGivenDeliveryDateMessage(): void
    {
        $messageTransfer = $this->messageGenerator->createNotAvailableForGivenDeliveryDateMessage();

        static::assertInstanceOf(MessageTransfer::class, $messageTransfer);
        static::assertEquals(MessageGenerator::TYPE_ERROR, $messageTransfer->getType());
        static::assertEquals(MessageGenerator::VALUE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE, $messageTransfer->getValue());
    }

    /**
     * @return void
     */
    public function testCreateNotAvailableForEarliestDeliveryDateMessage(): void
    {
        $messageTransfer = $this->messageGenerator->createNotAvailableForEarliestDeliveryDateMessage();

        static::assertInstanceOf(MessageTransfer::class, $messageTransfer);
        static::assertEquals(MessageGenerator::TYPE_ERROR, $messageTransfer->getType());
        static::assertEquals(MessageGenerator::VALUE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE, $messageTransfer->getValue());
    }

    /**
     * @return void
     */
    public function testCreateNotAvailableForGivenQytMessage(): void
    {
        $messageTransfer = $this->messageGenerator->createNotAvailableForGivenQytMessage();

        static::assertInstanceOf(MessageTransfer::class, $messageTransfer);
        static::assertEquals(MessageGenerator::TYPE_ERROR, $messageTransfer->getType());
    }
}
