<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\Cart;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade;
use Generated\Shared\Transfer\CartChangeTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPluginTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\CartChangeTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CartChangeTransfer|MockObject $cartChangeTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacade&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCartConnectorFacade|MockObject $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\Cart\ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin
     */
    protected ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->cartChangeTransferMock = $this->getMockBuilder(CartChangeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityCartConnectorGroupKeyItemExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpandItems(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandChangedCartItems')
            ->with($this->cartChangeTransferMock)
            ->willReturn($this->cartChangeTransferMock);

        static::assertEquals(
            $this->cartChangeTransferMock,
            $this->plugin->expandItems(
                $this->cartChangeTransferMock,
            ),
        );
    }
}
