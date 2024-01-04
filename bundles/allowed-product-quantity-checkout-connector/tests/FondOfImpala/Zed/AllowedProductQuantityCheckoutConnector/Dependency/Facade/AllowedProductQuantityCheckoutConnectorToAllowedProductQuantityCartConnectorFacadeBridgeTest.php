<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;

class AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge
     */
    protected $allowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacadeInterface
     */
    protected $allowedProductQuantityCartConnectorFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MessageTransfer
     */
    protected $messageTransferMock;

    /**
     * @var array
     */
    protected $messageTransferMocks;

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
