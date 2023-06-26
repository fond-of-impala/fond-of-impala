<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityItemExpanderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorServiceInterface|MockObject $serviceMock;

    /**
     * @var (\Generated\Shared\Transfer\CartChangeTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CartChangeTransfer|MockObject $cartChangeTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpander
     */
    protected ConditionalAvailabilityItemExpander $conditionalAvailabilityItemExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->serviceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartChangeTransferMock = $this->getMockBuilder(CartChangeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityItemExpander = new ConditionalAvailabilityItemExpander(
            $this->serviceMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $groupKey = 'foo';

        $this->cartChangeTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->serviceMock->expects(static::atLeastOnce())
            ->method('buildItemGroupKey')
            ->with($this->itemTransferMock)
            ->willReturn($groupKey);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setGroupKey')
            ->with($groupKey)
            ->willReturnSelf();

        static::assertEquals(
            $this->cartChangeTransferMock,
            $this->conditionalAvailabilityItemExpander->expand(
                $this->cartChangeTransferMock,
            ),
        );
    }
}
