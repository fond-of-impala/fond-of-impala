<?php

namespace FondOfImpala\Zed\CartValidation\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteItemValidationMessageClearerInterface;
use FondOfImpala\Zed\CartValidation\Business\Clearer\QuoteValidationMessageClearerInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CartValidationFacadeTest extends Unit
{
    protected MockObject|CartValidationBusinessFactory $businessFactoryMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|QuoteValidationMessageClearerInterface $quoteValidationMessageClearerMock;

    protected MockObject|QuoteItemValidationMessageClearerInterface $quoteItemValidationMessageClearerMock;

    protected CartValidationFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->businessFactoryMock = $this->getMockBuilder(CartValidationBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteValidationMessageClearerMock = $this->getMockBuilder(QuoteValidationMessageClearerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteItemValidationMessageClearerMock = $this->getMockBuilder(QuoteItemValidationMessageClearerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CartValidationFacade();
        $this->facade->setFactory($this->businessFactoryMock);
    }

    /**
     * @return void
     */
    public function testClearQuoteValidationMessages(): void
    {
        $this->businessFactoryMock->expects(static::atLeastOnce())
            ->method('createQuoteValidationMessageClearer')
            ->willReturn($this->quoteValidationMessageClearerMock);

        $this->quoteValidationMessageClearerMock->expects(static::atLeastOnce())
            ->method('clear')
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->facade->clearQuoteValidationMessages($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testClearQuoteItemValidationMessages(): void
    {
        $this->businessFactoryMock->expects(static::atLeastOnce())
            ->method('createQuoteItemValidationMessageClearer')
            ->willReturn($this->quoteItemValidationMessageClearerMock);

        $this->quoteItemValidationMessageClearerMock->expects(static::atLeastOnce())
            ->method('clear')
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->facade->clearQuoteItemValidationMessages($this->quoteTransferMock),
        );
    }
}
