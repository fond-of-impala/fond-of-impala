<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ItemGroupKeyBuilderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|GroupKeyBuilderInterface $groupKeyBuilderMock;

    /**
     * @var (\Generated\Shared\Transfer\ItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilder
     */
    protected ItemGroupKeyBuilder $itemGroupKeyBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->groupKeyBuilderMock = $this->getMockBuilder(GroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemGroupKeyBuilder = new ItemGroupKeyBuilder($this->groupKeyBuilderMock);
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $deliveryDate = 'bar';
        $sku = 'foo';
        $groupKey = sprintf('%s.%s', $sku, $deliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->groupKeyBuilderMock->expects(static::atLeastOnce())
            ->method('build')
            ->with($sku, $deliveryDate)
            ->willReturn($groupKey);

        static::assertEquals(
            $groupKey,
            $this->itemGroupKeyBuilder->build($this->itemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBuildEmptyDeliveryDate(): void
    {
        $sku = 'foo';

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(null);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        static::assertEquals(
            $sku,
            $this->itemGroupKeyBuilder->build($this->itemTransferMock),
        );
    }
}
