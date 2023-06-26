<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCartConnector\Plugin\CompanyUserCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Generated\Shared\Transfer\RestCartItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPluginTest extends Unit
{
    /**
     * @var (\FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorFactory|MockObject $factoryMock;

    /**
     * @var (\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorServiceInterface|MockObject $serviceMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCartItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCartItemTransfer|MockObject $restCartItemTransferMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityCartConnector\Plugin\CompanyUserCartsRestApi\ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin
     */
    protected ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $groupKey = 'foo.bar';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getService')
            ->willReturn($this->serviceMock);

        $this->serviceMock->expects(static::atLeastOnce())
            ->method('buildRestCartItemGroupKey')
            ->with($this->restCartItemTransferMock)
            ->willReturn($groupKey);

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('setGroupKey')
            ->with($groupKey)
            ->willReturnSelf();

        static::assertEquals(
            $this->restCartItemTransferMock,
            $this->plugin->expand($this->restCartItemTransferMock),
        );
    }
}
