<?php

namespace FondOfImpala\Zed\CartValidation\Business\Clearer;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteValidationMessageClearerTest extends Unit
{
    protected QuoteValidationMessageClearer $quoteItemValidationMessageClearer;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|ItemTransfer $itemTransferMock;

    protected array $itemTransferMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            $this->itemTransferMock,
        ];

        $this->quoteItemValidationMessageClearer = new QuoteValidationMessageClearer();
    }

    /**
     * @return void
     */
    public function testClearValidationMessages(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setValidationMessages')
            ->with(
                static::callback(
                    static fn (ArrayObject $validationMessages): bool => $validationMessages->count() === 0,
                ),
            )->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteItemValidationMessageClearer->clear($this->quoteTransferMock),
        );
    }
}
