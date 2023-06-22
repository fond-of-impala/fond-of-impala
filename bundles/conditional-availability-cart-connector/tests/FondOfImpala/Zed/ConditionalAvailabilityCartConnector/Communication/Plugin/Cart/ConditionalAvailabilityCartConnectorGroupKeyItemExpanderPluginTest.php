<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\Cart;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade;
use Generated\Shared\Transfer\CartChangeTransfer;

class ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\Cart\ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin
     */
    protected $conditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CartChangeTransfer
     */
    protected $cartChangeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade
     */
    protected $conditionalAvailabilityCartConnectorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->cartChangeTransferMock = $this->getMockBuilder(CartChangeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin = new ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin();
        $this->conditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin->setFacade($this->conditionalAvailabilityCartConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpandItems(): void
    {
        $this->conditionalAvailabilityCartConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('expandChangedCartItems')
            ->with($this->cartChangeTransferMock)
            ->willReturn($this->cartChangeTransferMock);

        $this->assertInstanceOf(
            CartChangeTransfer::class,
            $this->conditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin->expandItems(
                $this->cartChangeTransferMock,
            ),
        );
    }
}
