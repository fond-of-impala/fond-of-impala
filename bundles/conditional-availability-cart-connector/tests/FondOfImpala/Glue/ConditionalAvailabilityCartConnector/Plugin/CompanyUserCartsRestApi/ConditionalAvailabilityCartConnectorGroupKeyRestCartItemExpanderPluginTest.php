<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCartConnector\Plugin\CompanyUserCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Generated\Shared\Transfer\RestCartItemTransfer;

class ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityCartConnector\Plugin\CompanyUserCartsRestApi\ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin
     */
    protected $conditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCartItemTransfer
     */
    protected $restCartItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory
     */
    protected $conditionalAvailabilityCartConnectorFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected $conditionalAvailabilityCartConnectorServiceInterfaceMock;

    /**
     * @var string
     */
    protected $groupKey;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorFactoryMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorServiceInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->groupKey = 'group-key';

        $this->conditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin = new ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin();
        $this->conditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin->setFactory($this->conditionalAvailabilityCartConnectorFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->conditionalAvailabilityCartConnectorFactoryMock->expects($this->atLeastOnce())
            ->method('getService')
            ->willReturn($this->conditionalAvailabilityCartConnectorServiceInterfaceMock);

        $this->conditionalAvailabilityCartConnectorServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('buildRestCartItemGroupKey')
            ->with($this->restCartItemTransferMock)
            ->willReturn($this->groupKey);

        $this->restCartItemTransferMock->expects($this->atLeastOnce())
            ->method('setGroupKey')
            ->with($this->groupKey)
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestCartItemTransfer::class,
            $this->conditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin->expand(
                $this->restCartItemTransferMock,
            ),
        );
    }
}
