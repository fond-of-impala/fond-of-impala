<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridgeTest extends Unit
{
    protected AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge $allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge;

    protected MockObject|AllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacadeInterfaceMock;

    protected MockObject|ItemTransfer $itemTransferMock;

    protected MockObject|MessageTransfer $messageTransferMock;

    protected array $messageTransferMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityCartConnectorFacadeInterfaceMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageTransferMock = $this->getMockBuilder(MessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageTransferMocks = [
            $this->messageTransferMock,
        ];

        $this->allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge = new AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge(
            $this->allowedProductQuantityCartConnectorFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testValidateQuoteItem(): void
    {
        $this->allowedProductQuantityCartConnectorFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('validateQuoteItem')
            ->willReturn($this->messageTransferMocks);

        $this->assertIsArray($this->allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge->validateQuoteItem($this->itemTransferMock));
    }
}
