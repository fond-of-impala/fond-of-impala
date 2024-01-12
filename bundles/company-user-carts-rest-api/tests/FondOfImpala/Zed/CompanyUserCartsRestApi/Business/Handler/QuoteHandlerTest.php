<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class QuoteHandlerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemsCategorizerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemAdderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemRemoverMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var array<string, array<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>>
     */
    protected $categorizedItemTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsRequestAttributesTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $quoteResponseTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\QuoteErrorTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteErrorTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandler
     */
    protected $quoteHandler;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemsCategorizerMock = $this->getMockBuilder(ItemsCategorizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemAdderMock = $this->getMockBuilder(ItemAdderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemRemoverMock = $this->getMockBuilder(ItemRemoverInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categorizedItemTransferMocks = [
            ItemsCategorizerInterface::CATEGORY_ADDABLE => [
                $this->getMockBuilder(ItemTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
            ],
            ItemsCategorizerInterface::CATEGORY_REMOVABLE => [
                $this->getMockBuilder(ItemTransfer::class)
                    ->disableOriginalConstructor()
                    ->getMock(),
            ],
        ];

        $this->restCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMocks = [
            $this->getMockBuilder(QuoteResponseTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(QuoteResponseTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->quoteErrorTransferMock = $this->getMockBuilder(QuoteErrorTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteHandler = new QuoteHandler(
            $this->itemsCategorizerMock,
            $this->itemAdderMock,
            $this->itemRemoverMock,
        );
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCart')
            ->willReturn($this->restCartsRequestAttributesTransferMock);

        $this->itemsCategorizerMock->expects(static::atLeastOnce())
            ->method('categorize')
            ->with($this->quoteTransferMock, $this->restCartsRequestAttributesTransferMock)
            ->willReturn($this->categorizedItemTransferMocks);

        $this->itemAdderMock->expects(static::atLeastOnce())
            ->method('addMultiple')
            ->with(
                $this->quoteTransferMock,
                $this->categorizedItemTransferMocks[ItemsCategorizerInterface::CATEGORY_ADDABLE],
            )->willReturn($this->quoteResponseTransferMocks[0]);

        $this->quoteResponseTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteResponseTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMocks[0]->expects(static::never())
            ->method('getErrors');

        $this->itemRemoverMock->expects(static::atLeastOnce())
            ->method('removeMultiple')
            ->with(
                $this->quoteTransferMock,
                $this->categorizedItemTransferMocks[ItemsCategorizerInterface::CATEGORY_REMOVABLE],
            )->willReturn($this->quoteResponseTransferMocks[1]);

        $this->quoteResponseTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteResponseTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject());

        $restCompanyUserCartsResponseTransfer = $this->quoteHandler->handle(
            $this->quoteTransferMock,
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertTrue($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(0, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals($this->quoteTransferMock, $restCompanyUserCartsResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testHandleWithAddErrors(): void
    {
        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCart')
            ->willReturn($this->restCartsRequestAttributesTransferMock);

        $this->itemsCategorizerMock->expects(static::atLeastOnce())
            ->method('categorize')
            ->with($this->quoteTransferMock, $this->restCartsRequestAttributesTransferMock)
            ->willReturn($this->categorizedItemTransferMocks);

        $this->itemAdderMock->expects(static::atLeastOnce())
            ->method('addMultiple')
            ->with(
                $this->quoteTransferMock,
                $this->categorizedItemTransferMocks[ItemsCategorizerInterface::CATEGORY_ADDABLE],
            )->willReturn($this->quoteResponseTransferMocks[0]);

        $this->quoteResponseTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->quoteResponseTransferMocks[0]->expects(static::never())
            ->method('getQuoteTransfer');

        $this->quoteResponseTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject([$this->quoteErrorTransferMock]));

        $this->itemRemoverMock->expects(static::never())
            ->method('removeMultiple');

        $restCompanyUserCartsResponseTransfer = $this->quoteHandler->handle(
            $this->quoteTransferMock,
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertFalse($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(1, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertContains($this->quoteErrorTransferMock, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals(null, $restCompanyUserCartsResponseTransfer->getQuote());
    }

    /**
     * @return void
     */
    public function testHandleWithInvalidData(): void
    {
        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCart')
            ->willReturn(null);

        $this->itemsCategorizerMock->expects(static::never())
            ->method('categorize');

        $this->itemAdderMock->expects(static::never())
            ->method('addMultiple');

        $this->itemRemoverMock->expects(static::never())
            ->method('removeMultiple');

        $restCompanyUserCartsResponseTransfer = $this->quoteHandler->handle(
            $this->quoteTransferMock,
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertTrue($restCompanyUserCartsResponseTransfer->getIsSuccessful());
        static::assertCount(0, $restCompanyUserCartsResponseTransfer->getErrors());
        static::assertEquals($this->quoteTransferMock, $restCompanyUserCartsResponseTransfer->getQuote());
    }
}
