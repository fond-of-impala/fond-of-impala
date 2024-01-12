<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsDiscountsTransfer;
use Generated\Shared\Transfer\RestCartsTotalsTransfer;
use Generated\Shared\Transfer\StoreTransfer;

class RestCartsAttributesMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsDiscountsMapperMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsTotalsMapperMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CurrencyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $currencyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsTotalsTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsTotalsTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsDiscountsTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsDiscountsTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapper
     */
    protected $restCartsAttributesMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCartsDiscountsMapperMock = $this->getMockBuilder(RestCartsDiscountsMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsTotalsMapperMock = $this->getMockBuilder(RestCartsTotalsMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsTotalsTransferMock = $this->getMockBuilder(RestCartsTotalsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsDiscountsTransferMock = $this->getMockBuilder(RestCartsDiscountsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsAttributesMapper = new RestCartsAttributesMapper(
            $this->restCartsDiscountsMapperMock,
            $this->restCartsTotalsMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $currencyCode = 'EUR';
        $storeName = 'FOO';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCurrency')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getCode')
            ->willReturn($currencyCode);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($storeName);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restCartsTotalsMapperMock->expects(static::atLeastOnce())
            ->method('fromQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restCartsTotalsTransferMock);

        $this->restCartsDiscountsMapperMock->expects(static::atLeastOnce())
            ->method('fromQuote')
            ->with($this->quoteTransferMock)
            ->willReturn([$this->restCartsDiscountsTransferMock]);

        $restCartsAttributesTransfer = $this->restCartsAttributesMapper->fromQuote($this->quoteTransferMock);

        static::assertEquals($storeName, $restCartsAttributesTransfer->getStore());
        static::assertEquals($currencyCode, $restCartsAttributesTransfer->getCurrency());
        static::assertEquals($this->restCartsTotalsTransferMock, $restCartsAttributesTransfer->getTotals());
        static::assertContains($this->restCartsDiscountsTransferMock, $restCartsAttributesTransfer->getDiscounts());
    }
}
