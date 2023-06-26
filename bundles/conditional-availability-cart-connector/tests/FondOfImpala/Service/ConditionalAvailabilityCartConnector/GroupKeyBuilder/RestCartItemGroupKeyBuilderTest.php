<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCartItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestCartItemGroupKeyBuilderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|GroupKeyBuilderInterface $groupKeyBuilderMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCartItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCartItemTransfer|MockObject $restCartItemTransferMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilder
     */
    protected RestCartItemGroupKeyBuilder $restCartItemGroupKeyBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->groupKeyBuilderMock = $this->getMockBuilder(GroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemGroupKeyBuilder = new RestCartItemGroupKeyBuilder(
            $this->groupKeyBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $deliveryDate = 'bar';
        $sku = 'foo';
        $groupKey = sprintf('%s.%s', $sku, $deliveryDate);

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->groupKeyBuilderMock->expects(static::atLeastOnce())
            ->method('build')
            ->with($sku, $deliveryDate)
            ->willReturn($groupKey);

        static::assertEquals(
            $groupKey,
            $this->restCartItemGroupKeyBuilder->build($this->restCartItemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBuildEmptyDeliveryDate(): void
    {
        $sku = 'foo';

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(null);

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        static::assertSame(
            $sku,
            $this->restCartItemGroupKeyBuilder->build($this->restCartItemTransferMock),
        );
    }
}
