<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;

class ItemGroupKeyBuilderTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilder
     */
    protected $itemGroupKeyBuilder;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface
     */
    protected $groupKeyBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var string
     */
    protected $deliveryDate;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $groupKey;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->groupKeyBuilderInterfaceMock = $this->getMockBuilder(GroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->deliveryDate = 'delivery-date';

        $this->sku = 'sku';

        $this->groupKey = "{$this->sku}.{$this->deliveryDate}";

        $this->itemGroupKeyBuilder = new ItemGroupKeyBuilder($this->groupKeyBuilderInterfaceMock);
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($this->deliveryDate);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->groupKeyBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('build')
            ->with($this->sku, $this->deliveryDate)
            ->willReturn($this->groupKey);

        $this->assertSame(
            $this->groupKey,
            $this->itemGroupKeyBuilder->build($this->itemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBuildEmptyDeliveryDate(): void
    {
        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(null);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->assertSame(
            $this->sku,
            $this->itemGroupKeyBuilder->build($this->itemTransferMock),
        );
    }
}
