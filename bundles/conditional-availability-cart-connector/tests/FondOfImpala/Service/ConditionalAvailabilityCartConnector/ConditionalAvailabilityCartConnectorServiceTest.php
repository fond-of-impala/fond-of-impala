<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;

class ConditionalAvailabilityCartConnectorServiceTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorService
     */
    protected $conditionalAvailabilityCartConnectorService;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceFactory
     */
    protected $conditionalAvailabilityCartConnectorServiceFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface
     */
    protected $itemGroupKeyBuilderInterfaceMock;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $deliveryDate;

    /**
     * @var string
     */
    protected $groupKey;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCartItemTransfer
     */
    protected $restCartItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface
     */
    protected $restCartItemGroupKeyBuilderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorServiceFactoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemGroupKeyBuilderInterfaceMock = $this->getMockBuilder(ItemGroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemGroupKeyBuilderInterfaceMock = $this->getMockBuilder(RestCartItemGroupKeyBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sku = 'sku';

        $this->deliveryDate = 'deliver-date';

        $this->groupKey = "{$this->sku}.{$this->deliveryDate}";

        $this->conditionalAvailabilityCartConnectorService = new ConditionalAvailabilityCartConnectorService();
        $this->conditionalAvailabilityCartConnectorService->setFactory($this->conditionalAvailabilityCartConnectorServiceFactoryMock);
    }

    /**
     * @return void
     */
    public function testBuildItemGroupKey(): void
    {
        $this->conditionalAvailabilityCartConnectorServiceFactoryMock->expects($this->atLeastOnce())
            ->method('createItemGroupKeyBuilder')
            ->willReturn($this->itemGroupKeyBuilderInterfaceMock);

        $this->itemGroupKeyBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('build')
            ->with($this->itemTransferMock)
            ->willReturn($this->groupKey);

        $this->assertSame(
            $this->groupKey,
            $this->conditionalAvailabilityCartConnectorService->buildItemGroupKey(
                $this->itemTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testBuildRestCartItemGroupKey(): void
    {
        $this->conditionalAvailabilityCartConnectorServiceFactoryMock->expects($this->atLeastOnce())
            ->method('createRestCartItemGroupKeyBuilder')
            ->willReturn($this->restCartItemGroupKeyBuilderInterfaceMock);

        $this->restCartItemGroupKeyBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('build')
            ->with($this->restCartItemTransferMock)
            ->willReturn($this->groupKey);

        $this->assertSame(
            $this->groupKey,
            $this->conditionalAvailabilityCartConnectorService->buildRestCartItemGroupKey(
                $this->restCartItemTransferMock,
            ),
        );
    }
}
