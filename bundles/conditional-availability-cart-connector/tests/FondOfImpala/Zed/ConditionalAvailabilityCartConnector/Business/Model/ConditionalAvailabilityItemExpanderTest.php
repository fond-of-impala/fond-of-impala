<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;

class ConditionalAvailabilityItemExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpander
     */
    protected $conditionalAvailabilityItemExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected $conditionalAvailabilityCartConnectorServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CartChangeTransfer
     */
    protected $cartChangeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMocks;

    /**
     * @var string
     */
    protected $groupKey;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorServiceInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartChangeTransferMock = $this->getMockBuilder(CartChangeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = new ArrayObject([
            $this->itemTransferMock,
        ]);

        $this->groupKey = 'group-key';

        $this->conditionalAvailabilityItemExpander = new ConditionalAvailabilityItemExpander(
            $this->conditionalAvailabilityCartConnectorServiceInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->cartChangeTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->conditionalAvailabilityCartConnectorServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('buildItemGroupKey')
            ->with($this->itemTransferMock)
            ->willReturn($this->groupKey);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('setGroupKey')
            ->with($this->groupKey)
            ->willReturnSelf();

        $this->assertInstanceOf(
            CartChangeTransfer::class,
            $this->conditionalAvailabilityItemExpander->expand(
                $this->cartChangeTransferMock,
            ),
        );
    }
}
