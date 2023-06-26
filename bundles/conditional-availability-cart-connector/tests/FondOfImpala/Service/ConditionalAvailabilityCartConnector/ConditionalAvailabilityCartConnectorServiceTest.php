<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorServiceTest extends Unit
{
    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorServiceFactory|MockObject $factoryMock;

    /**
     * @var (\Generated\Shared\Transfer\ItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ItemGroupKeyBuilderInterface|MockObject $itemGroupKeyBuilderMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCartItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCartItemTransfer|MockObject $restCartItemTransferMock;

    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCartItemGroupKeyBuilderInterface|MockObject $restCartItemGroupKeyBuilderMock;

    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorService
     */
    protected ConditionalAvailabilityCartConnectorService $service;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemGroupKeyBuilderMock = $this->getMockBuilder(ItemGroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemGroupKeyBuilderMock = $this->getMockBuilder(RestCartItemGroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new ConditionalAvailabilityCartConnectorService();
        $this->service->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testBuildItemGroupKey(): void
    {
        $groupKey = 'foo.bar';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createItemGroupKeyBuilder')
            ->willReturn($this->itemGroupKeyBuilderMock);

        $this->itemGroupKeyBuilderMock->expects(static::atLeastOnce())
            ->method('build')
            ->with($this->itemTransferMock)
            ->willReturn($groupKey);

        static::assertEquals(
            $groupKey,
            $this->service->buildItemGroupKey($this->itemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBuildRestCartItemGroupKey(): void
    {
        $groupKey = 'foo.bar';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createRestCartItemGroupKeyBuilder')
            ->willReturn($this->restCartItemGroupKeyBuilderMock);

        $this->restCartItemGroupKeyBuilderMock->expects(static::atLeastOnce())
            ->method('build')
            ->with($this->restCartItemTransferMock)
            ->willReturn($groupKey);

        static::assertEquals(
            $groupKey,
            $this->service->buildRestCartItemGroupKey($this->restCartItemTransferMock),
        );
    }
}
