<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ItemAdderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $cartFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdder
     */
    protected $itemAdder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->cartFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToCartFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemAdder = new ItemAdder($this->cartFacadeMock);
    }

    /**
     * @return void
     */
    public function testAddMultiple(): void
    {
        $self = $this;

        $this->cartFacadeMock->expects(static::atLeastOnce())
            ->method('addToCart')
            ->with(
                static::callback(
                    static function (CartChangeTransfer $cartChangeTransfer) use ($self) {
                        return $cartChangeTransfer->getQuote() === $self->quoteTransferMock
                            && $cartChangeTransfer->getItems()->count() === 1
                            && $cartChangeTransfer->getItems()->offsetGet(0) === $self->itemTransferMock;
                    },
                ),
            )->willReturn($this->quoteResponseTransferMock);

        static::assertEquals(
            $this->quoteResponseTransferMock,
            $this->itemAdder->addMultiple($this->quoteTransferMock, [$this->itemTransferMock]),
        );
    }

    /**
     * @return void
     */
    public function testAddMultipleWithEmptyItems(): void
    {
        $this->cartFacadeMock->expects(static::never())
            ->method('addToCart');

        $quoteResponseTransfer = $this->itemAdder->addMultiple($this->quoteTransferMock, []);

        static::assertTrue($quoteResponseTransfer->getIsSuccessful());

        static::assertEquals(
            $this->quoteTransferMock,
            $quoteResponseTransfer->getQuoteTransfer(),
        );
    }
}
