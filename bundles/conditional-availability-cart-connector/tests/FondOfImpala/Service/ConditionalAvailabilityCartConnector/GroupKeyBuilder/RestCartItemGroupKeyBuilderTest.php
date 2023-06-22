<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCartItemTransfer;

class RestCartItemGroupKeyBuilderTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilder
     */
    protected $restCartItemGroupKeyBuilder;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface
     */
    protected $groupKeyBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCartItemTransfer
     */
    protected $restCartItemTransferMock;

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

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->deliveryDate = 'delivery-date';

        $this->sku = 'sku';

        $this->groupKey = "{$this->sku}.{$this->deliveryDate}";

        $this->restCartItemGroupKeyBuilder = new RestCartItemGroupKeyBuilder(
            $this->groupKeyBuilderInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $this->restCartItemTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($this->deliveryDate);

        $this->restCartItemTransferMock->expects($this->atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->groupKeyBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('build')
            ->with($this->sku, $this->deliveryDate)
            ->willReturn($this->groupKey);

        $this->assertSame(
            $this->groupKey,
            $this->restCartItemGroupKeyBuilder->build($this->restCartItemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBuildEmptyDeliveryDate(): void
    {
        $this->restCartItemTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(null);

        $this->restCartItemTransferMock->expects($this->atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->assertSame(
            $this->sku,
            $this->restCartItemGroupKeyBuilder->build($this->restCartItemTransferMock),
        );
    }
}
