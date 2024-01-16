<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TaxTotalTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

class RestCartsTotalsMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\TotalsTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $totalsTransferMock;

    /**
     * @var \Generated\Shared\Transfer\TaxTotalTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $taxTotalTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapper
     */
    protected $restCartsTotalsMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->totalsTransferMock = $this->getMockBuilder(TotalsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->taxTotalTransferMock = $this->getMockBuilder(TaxTotalTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsTotalsMapper = new RestCartsTotalsMapper();
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $amount = 100;

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getTotals')
            ->willReturn($this->totalsTransferMock);

        $this->totalsTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->totalsTransferMock->expects(static::atLeastOnce())
            ->method('getTaxTotal')
            ->willReturn($this->taxTotalTransferMock);

        $this->taxTotalTransferMock->expects(static::atLeastOnce())
            ->method('getAmount')
            ->willReturn($amount);

        $restCartsTotalsTransfer = $this->restCartsTotalsMapper->fromQuote($this->quoteTransferMock);

        static::assertEquals(
            $amount,
            $restCartsTotalsTransfer->getTaxTotal(),
        );
    }

    /**
     * @return void
     */
    public function testFromQuoteWithoutTotals(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getTotals')
            ->willReturn(null);

        $restCartsTotalsTransfer = $this->restCartsTotalsMapper->fromQuote($this->quoteTransferMock);

        static::assertEquals(
            null,
            $restCartsTotalsTransfer->getTaxTotal(),
        );
    }
}
