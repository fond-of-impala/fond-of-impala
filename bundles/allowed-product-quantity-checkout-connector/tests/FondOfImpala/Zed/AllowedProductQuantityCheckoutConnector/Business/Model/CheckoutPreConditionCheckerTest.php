<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutPreConditionCheckerTest extends Unit
{
    protected CheckoutPreConditionChecker $checkoutPreConditionChecker;

    protected MockObject|AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacadeMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|CheckoutResponseTransfer $checkoutResponseTransferMock;

    protected MockObject|ItemTransfer $itemTransferMock;

    protected array $itemTransferMocks;

    protected MockObject|MessageTransfer $messageTransferMock;

    protected array $messageTransferMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityCartConnectorFacadeMock = $this->getMockBuilder(AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            $this->itemTransferMock,
        ];

        $this->messageTransferMock = $this->getMockBuilder(MessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageTransferMocks = [
            $this->messageTransferMock,
        ];

        $this->checkoutPreConditionChecker = new CheckoutPreConditionChecker($this->allowedProductQuantityCartConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testCheck(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->allowedProductQuantityCartConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('validateQuoteItem')
            ->willReturn($this->messageTransferMocks);

        $this->checkoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('setIsSuccess')
            ->willReturn($this->checkoutResponseTransferMock);

        $this->assertFalse($this->checkoutPreConditionChecker->check($this->quoteTransferMock, $this->checkoutResponseTransferMock));
    }
}
