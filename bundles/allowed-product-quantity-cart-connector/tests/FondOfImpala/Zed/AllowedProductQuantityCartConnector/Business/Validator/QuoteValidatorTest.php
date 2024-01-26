<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteValidatorTest extends Unit
{
    protected ItemsValidatorInterface|MockObject $itemsValidatorMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected ItemTransfer|MockObject $itemTransferMock;

    protected QuoteValidator $quoteValidator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemsValidatorMock = $this->getMockBuilder(ItemsValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteValidator = new QuoteValidator($this->itemsValidatorMock);
    }

    /**
     * @return void
     */
    public function testValidateAndAppendResult(): void
    {
        $itemTransfers = new ArrayObject([$this->itemTransferMock]);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn($itemTransfers);

        $this->itemsValidatorMock->expects($this->atLeastOnce())
            ->method('validateAndAppendResult')
            ->with($itemTransfers)
            ->willReturn($itemTransfers);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setItems')
            ->with($itemTransfers)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteValidator->validateAndAppendResult($this->quoteTransferMock),
        );
    }
}
